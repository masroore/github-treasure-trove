<?php

namespace App\Http\Livewire;

use App\Events\NewMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageBoard extends Component
{
    public $contact;

    public $messageValue = '';

    public $messageCount = 10;

    protected $messages = [];

    public function getListeners()
    {
        return [
            'updatedConversation',
            'moreMessage',
            'echo-private:messages.' . Auth::id() . ',.new.message' => '$refresh',
        ];
    }

    public function render()
    {
        if (!$this->contact) {
            $this->messages = [];
        } else {
            $this->readMessage();
        }

        return view('livewire.message-board', [
            'messages' => $this->messages,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function moreMessage(): void
    {
        $this->messageCount = $this->messageCount + 10;
    }

    public function updatedConversation($contactId): void
    {
        $this->messageCount = 10;
        $this->contact = User::find($contactId);
    }

    public function sendMessage(): void
    {
        if ($this->contact) {
            $this->validate([
                'messageValue' => 'required',
            ]);
            $message = sanitizeString($this->messageValue);
            Auth::user()->sendMessage($message, $this->contact->id);
            broadcast(new NewMessage($this->contact));
            $this->emit('refreshMessages');
            $this->messageValue = '';
        }
    }

    public function readMessage(): void
    {
        if (auth()->user()->contactMessages($this->contact->id)->count()) {
            $this->messages = auth()->user()->contactMessages($this->contact->id)->orderByDesc('created_at')->get()->take($this->messageCount);
        } else {
            $this->messages = [];
        }
    }
}
