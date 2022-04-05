<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReviewMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public $pro;

    public $msg;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $pro, $msg)
    {
        $this->user = $user;
        $this->pro = $pro;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.reviewmail')->subject($this->msg . ' ' . $this->pro);
    }
}
