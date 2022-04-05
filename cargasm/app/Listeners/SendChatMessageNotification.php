<?php

namespace App\Listeners;

use App\Events\NewChatMessage;

class SendChatMessageNotification
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
    public function handle(NewChatMessage $event): void
    {

    }
}
