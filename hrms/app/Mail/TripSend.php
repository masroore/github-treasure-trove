<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $trip;

    /**
     * Create a new message instance.
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.trip_send')->with('trip', $this->trip)->subject('Ragarding to trip letter.');
    }
}
