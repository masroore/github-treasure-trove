<?php

namespace App\Listeners;

use App\Events\UserSubscribedToTopic;
use App\Mail\UserSubscribedToTopic as UserSubscribedToTopicEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendTopicOwnerSubscriptionCreatedEmail implements ShouldQueue
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
    public function handle(UserSubscribedToTopic $event): void
    {
        Mail::to($event->topic->user()->first())->queue(new UserSubscribedToTopicEmail($event->topic));
    }
}
