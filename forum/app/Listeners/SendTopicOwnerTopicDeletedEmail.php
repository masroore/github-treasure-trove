<?php

namespace App\Listeners;

use App\Events\TopicDeleted;
use App\Mail\TopicDeleted as TopicDeletedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendTopicOwnerTopicDeletedEmail implements ShouldQueue
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
    public function handle(TopicDeleted $event): void
    {
        Mail::to($event->topic->user->email)->queue(new TopicDeletedEmail($event->topic));
    }
}
