<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreOrderNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $value;

    /**
     * Create a new message instance.
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.preordernotification');
    }
}
