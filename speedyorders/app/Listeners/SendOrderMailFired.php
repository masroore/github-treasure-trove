<?php

namespace App\Listeners;

use App\Events\SendOrderMail;
use App\Mail\OrderMail;
use Mail;

class SendOrderMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SendOrderMail $event)
    {
        Mail::to($event->email)->send(new OrderMail($event->pdf));
    }
}
