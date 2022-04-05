<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescheduleReminder extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $estimate;

    /**
     * Create a new message instance.
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reschedule')->subject('Reschedule Request');
    }
}
