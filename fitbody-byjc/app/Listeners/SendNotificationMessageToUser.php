<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Notifications\MessageReceived;
use Illuminate\Support\Facades\Notification;

class SendNotificationMessageToUser
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
    public function handle(MessageSent $event)
    {
        Notification::send($event->message->recipient, new MessageReceived($event->message));
    }
}
