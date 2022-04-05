<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Notifications\MessageReceived;
use Illuminate\Support\Facades\Notification;

class SendNotificationMessageToUser
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
        Notification::send($event->message->recipient, new MessageReceived($event->message));
    }
}
