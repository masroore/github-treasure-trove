<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketReplay extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $hd;

    public $newmsg;

    /**
     * Create a new message instance.
     */
    public function __construct($hd, $newmsg)
    {
        $this->hd = $hd;
        $this->newmsg = $newmsg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.ticketreplay')->subject('Re #' . $this->hd->ticket_no . '  ' . $this->hd->issue_title);
    }
}
