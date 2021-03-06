<?php

namespace App\Listeners;

use App\Events\UserPostedOnTopic;
use App\Mail\UserPostedOnTopic as UserPostedOnTopicEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendTopicSubscribersPostEmail implements ShouldQueue
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
    public function handle(UserPostedOnTopic $event): void
    {
        // get subscriptions where a subscription both exists and has a subscribed field of 1
        $subscriptions = $event->topic->subscriptions()->where('subscribed', 1)->get();
        $current_user = $event->user;
        if (count($subscriptions)) {
            foreach ($subscriptions as $subscription) {
                $user = $subscription->user()->first();
                if ($user->id !== $current_user->id) {
                    // only send an email to a user if they are subscribed AND are not the current user
                    Mail::to($user)->queue(new UserPostedOnTopicEmail($event->topic, $event->post));
                }
            }
        }
    }
}
