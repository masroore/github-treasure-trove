<?php

namespace App\Listeners;

use App\Events\UserHasViewedMessagesFromSender;

class UpdateReadFlagOnMessagesForGivenSender
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
    public function handle(UserHasViewedMessagesFromSender $event): void
    {
        foreach ($event->currentUser->receivedMessagesFromSender($event->sender) as $message) {
            $message->update([
                'read' => 1,
            ]);
            $message->save();
        }
    }
}
