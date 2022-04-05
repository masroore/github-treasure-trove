<?php

namespace App\Http\Livewire\Messages;

use App\Models\Message;
use Livewire\Component;

class DisplayMessages extends Component
{
    public $messages = [];

    public $detail = [];

    public $readMode = false;

    public $email;

    public $name;

    public $subject;

    public $content;

    public $messageId;

    public function render()
    {
        $this->messages = Message::get();

        return view('livewire.messages.display-messages');
    }

    public function destroy($id): void
    {
        if ($id) {
            $record = Message::where('id', $id);
            $record->delete();
            $this->readMode = false;
        }
    }

    public function read($id): void
    {
        $detail = Message::find($id);
        $this->name = $detail->name;
        $this->email = $detail->email;
        $this->subject = $detail->subject;
        $this->content = $detail->content;
        $this->messageId = $detail->id;

        $this->readMode = true;
    }

    public function back($id): void
    {
        $this->readMode = false;
    }
}
