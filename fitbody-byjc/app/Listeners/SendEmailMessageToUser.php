<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendEmailMessageToUser
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
    public function handle(MessageSent $event): void
    {
        Mail::to($event->message->recipient)->send(new Message($event->message));
    }
}
