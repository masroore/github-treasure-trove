<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintsSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $complaints;

    /**
     * Create a new message instance.
     */
    public function __construct($complaints)
    {
        $this->complaints = $complaints;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.complaints_send')->with('complaints', $this->complaints)->subject('Ragarding to job complaints letter.');
    }
}
