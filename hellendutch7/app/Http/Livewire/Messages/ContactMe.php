<?php

namespace App\Http\Livewire\Messages;

use App\Models\Message;
use Livewire\Component;

class ContactMe extends Component
{
    public $name;

    public $email;

    public $subject;

    public $content;

    public $my_question;

    public function render()
    {
        return view('livewire.messages.contact-me');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required | min:5| max:24 ',
            'email' => 'required |email',
            'subject' => 'required | min:5| max:50',
            'content' => 'required | min:10| max:500',
            'my_question' => 'required',
        ]);

        if (strtoupper($this->my_question) !== 'DUTCH') {
            return view('livewire.messages.contact-me');
        }
        $message = new Message();

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'content' => $this->content,
        ]);

        return redirect('/');
    }
}
