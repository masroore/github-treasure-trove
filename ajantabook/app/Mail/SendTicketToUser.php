<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketToUser extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $hd;

    /**
     * Create a new message instance.
     */
    public function __construct($hd)
    {
        $this->hd = $hd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.ticket')->subject('#' . $this->hd->ticket_no . ' Ticket has been created');
    }
}
