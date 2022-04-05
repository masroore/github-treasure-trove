<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketToAdmin extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $hd;

    public $get_user_name;

    /**
     * Create a new message instance.
     */
    public function __construct($hd, $get_user_name)
    {
        $this->hd = $hd;
        $this->get_user_name = $get_user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.SendTicketToAdmin')->subject('#' . $this->hd->ticket_no . ' Ticket Received');
    }
}
