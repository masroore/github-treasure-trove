<?php

namespace App\Listeners;

use App\Events\UserRoleModified;
use App\Mail\UserRoleModified as UserRoleModifiedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendUserRoleModifiedEmail implements ShouldQueue
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
    public function handle(UserRoleModified $event): void
    {
        Mail::to($event->user->email)->queue(new UserRoleModifiedEmail($event->old_role, $event->user));
    }
}
