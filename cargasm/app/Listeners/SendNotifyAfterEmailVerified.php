<?php

namespace App\Listeners;

use App\Notifications\MailConfirm;
use Illuminate\Support\Facades\Notification;

class SendNotifyAfterEmailVerified
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $user = $event->user;
        Notification::send($user, new MailConfirm());
    }
}
