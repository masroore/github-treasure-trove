<?php

namespace App\Listeners;

use App\Events\SendOrderMail;
use App\Mail\OrderMail;
use Mail;

class SendOrderMailFired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(SendOrderMail $event): void
    {
        Mail::to($event->email)->send(new OrderMail($event->pdf));
    }
}
