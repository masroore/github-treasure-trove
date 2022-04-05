<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageContacts extends Component
{
    public $messagesPerPage = 10;

    public $contactsPerPage = 10;

    public $showContactSearch = false;

    public $searchContact = '';

    public function getListeners()
    {
        return [
            'loadMore',
            'updatedConversation' => '$refresh',
            'echo-private:messages.' . Auth::id() . ',.new.message' => '$refresh',
            'refreshMessages' => '$refresh',
        ];
    }

    public function render()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $contacts = User::query();

        if ($this->searchContact) {
            $contacts = $contacts->where('name', 'like', "%$this->searchContact%")->orderBy('name')->get()->take($this->contactsPerPage);
        } else {
            $contacts = $contacts->orderBy('name')->get()->take($this->contactsPerPage);
        }

        return view('livewire.message-contacts', [
            'latest_messages' => auth()->user()->latest_messages->take($this->messagesPerPage),
            'contacts' => $contacts,
        ]);
    }

    public function loadMore(): void
    {
        if ($this->showContactSearch) {
            if (User::all()->count() <= $this->contactsPerPage) {
                return;
            }
            $this->contactsPerPage = $this->contactsPerPage + 5;
        }
        if (auth()->user()->latest_messages->count() <= $this->messagesPerPage) {
            return;
        }
        $this->messagesPerPage = $this->messagesPerPage + 5;
    }

    public function newMessage(): void
    {
        Message::factory()->create(['receiver_id' => Auth::id()]);
    }

    public function openContactSearch(): void
    {
        $this->showContactSearch = true;
        $this->messagesPerPage = 10;
    }

    public function closeContactSearch(): void
    {
        $this->showContactSearch = false;
        $this->contactsPerPage = 10;
        $this->searchContact = '';
    }

    public function contactClicked($contactId): void
    {
        if (auth()->user()->contactMessages($contactId)->count()) {
            Auth::user()->contactMessages($contactId)->update(['read_at' => Carbon::now()]);
        }
        $this->emit('updatedConversation', $contactId);
    }
}
