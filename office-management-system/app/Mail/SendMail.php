<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;

    public $description;

    public function __construct($subject, $description)
    {
        $this->subject = $subject;
        $this->description = $description;
    }

    public function build()
    {
        return $this->view('emails.send_mail');
    }
}
