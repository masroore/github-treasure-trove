<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMe extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;

    public $message;

    /**
     * Create a new $message instance.
     *
     * @param $name
     * @param $message
     */
    public function __construct($name, $message)
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->name . ' sent you a message in larablog')
            ->markdown('email.contact-me');
    }
}
