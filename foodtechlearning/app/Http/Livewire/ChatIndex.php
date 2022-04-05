<?php

namespace App\Http\Livewire;

use App\Models\Chatroom;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Log;
use Throwable;

class ChatIndex extends Component
{
    public $message_per_page = 10;

    public $chatrooms_per_page = 20;

    protected $queryString = ['current'];

    public $current;

    public $search = '';

    public $message = '';

    public $new_member = '';

    public ?User $recipient = null;

    public ?Chatroom $active_chatroom = null;

    public function render()
    {
        $chatrooms = auth()->user()?->chatrooms()
            ->has('course')
            ->orWhere('course_id', null)
            ->with('course');
        if ($this->search) {
            $chatrooms = $chatrooms->where('name', 'like', "%$this->search%");
            $users = User::where('first_name', 'like', "%$this->search%")->orWhere('last_name', 'like', "%$this->search%")->take(10)->get();
        } else {
            $chatrooms = $chatrooms->latestMessage();
            $users = [];
        }
        if ($this->active_chatroom) {
            $messages = $this->active_chatroom?->messages()->withTrashed()->take($this->message_per_page)->get();
        } else {
            $messages = collect();
        }

        return view('livewire.chat-index', [
            'chatrooms' => $chatrooms->take($this->chatrooms_per_page)->get(),
            'messages' => $messages,
            'users' => $users,
        ]);
    }

    public function mount(): void
    {
        if (request('current')) {
            $this->active_chatroom = auth()->user()?->chatrooms()->findOrFail(request('current'));
        } else {
            $chatrooms = auth()->user()?->chatrooms()->with('course')->latestMessage()->take($this->chatrooms_per_page)->get();
            $this->active_chatroom = $chatrooms->first();
        }

        if ($this->active_chatroom && $this->active_chatroom?->pivot->message_id !== $this->active_chatroom?->latest_message?->id) {
            $this->active_chatroom?->pivot->update([
                'message_id' => $this->active_chatroom?->latest_message?->id,
            ]);
        }
    }

    public function change_active_chatroom($chatroom): void
    {
        $chatroom = auth()->user()?->chatrooms()->find($chatroom);
        if ($chatroom?->pivot->message_id !== $chatroom?->latest_message?->id) {
            $chatroom?->pivot->update([
                'message_id' => $chatroom->latest_message?->id,
            ]);
            $this->emit('message_read');
        }
        $this->active_chatroom = $chatroom;
        $this->current = $chatroom->id;
        $this->message_per_page = 30;
        $this->recipient = null;
        $this->message = '';
    }

    public function add_member()
    {
        $user = User::whereEmail($this->new_member)->first();
        if (!$user) {
            return $this->alert('error', 'User not found.');
        }
        if (!$this->active_chatroom || !$this->active_chatroom?->course_id) {
            return;
        }

        $this->active_chatroom->users()->attach($user);
        $this->new_member = '';
        $this->active_chatroom->refresh();

        return $this->alert('success', 'User added.');
    }

    public function change_recipient(User $recipient)
    {
        if ($recipient->id == auth()->id()) {
            return $this->alert('error', 'Cannot start a conversation with yourself.');
        }
        $existing = auth()->user()?->chatrooms()->whereHas('users', function (Builder $query) use ($recipient): void {
            $query->where('user_id', $recipient->id);
        })->whereNull('name')->first();
        if ($existing) {
            $this->active_chatroom = $existing;
        } else {
            $this->recipient = $recipient;
            $this->active_chatroom = null;
        }
        $this->search = '';
        $this->message = '';
    }

    public function updating($name, $value): void
    {
        if ($name !== 'message') {
            $this->message = '';
        }
    }

    public function send_message()
    {
        $this->validate([
            'message' => 'required',
        ]);

        try {
            DB::transaction(function (): void {
                if ($this->active_chatroom) {
                    $this->active_chatroom->messages()->create([
                        'user_id' => auth()->id(),
                        'body' => $this->message,
                    ]);
                    $this->active_chatroom = auth()->user()?->chatrooms()->find($this->active_chatroom->id);
                } else {
                    $chatroom = Chatroom::create([]);
                    $chatroom->users()->syncWithoutDetaching([auth()->id(), $this->recipient->id]);
                    $chatroom->messages()->create([
                        'user_id' => auth()->id(),
                        'body' => $this->message,
                    ]);
                    $this->active_chatroom = auth()->user()?->chatrooms()->find($chatroom->id);
                }
                // foreach ($this->active_chatroom->users->except(auth()->id()) as $user) {
                //     NewMessageSentEvent::dispatch($user->id);
                // }
                if ($this->active_chatroom?->pivot->message_id !== $this->active_chatroom->latest_message?->id) {
                    $this->active_chatroom?->pivot->update([
                        'message_id' => $this->active_chatroom->latest_message?->id,
                    ]);
                    $this->emit('message_read');
                }
            });
        } catch (Throwable $exception) {
            Log::channel('info')->alert($exception->getMessage());

            return $this->alert('error', 'Something went wrong. Please try again later.');
        }
        $this->recipient = null;
        $this->message = '';
    }
}
