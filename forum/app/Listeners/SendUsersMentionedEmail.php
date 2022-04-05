<?php

namespace App\Listeners;

use App\Events\UsersMentioned;
use App\Mail\UserMentioned as UserMentionedEmail;
use Mail;

class SendUsersMentionedEmail
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
    public function handle(UsersMentioned $event): void
    {
        $users = $event->users->unique();
        if (count($users)) {
            foreach ($users as $user) {
                Mail::to($user)->queue(new UserMentionedEmail($event->topic, $event->post));
            }
        }
    }
}
