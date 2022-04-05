<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUser extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;

    public $email;

    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($mailBody)
    {
        $this->name = $mailBody['name'];
        $this->email = $mailBody['email'];
        $this->password = $mailBody['password'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Baby Passport - Credenciales de Usuario')
            ->to($this->email)
            ->view('emails.mom-user');
    }
}
