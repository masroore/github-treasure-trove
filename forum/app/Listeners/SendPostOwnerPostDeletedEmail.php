<?php

namespace App\Listeners;

use App\Events\PostDeleted;
use App\Mail\PostDeleted as PostDeletedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendPostOwnerPostDeletedEmail implements ShouldQueue
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
    public function handle(PostDeleted $event): void
    {
        Mail::to($post->user->email)->queue(new PostDeletedEmail($post));
    }
}
