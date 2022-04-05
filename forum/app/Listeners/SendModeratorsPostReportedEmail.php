<?php

namespace App\Listeners;

use App\Events\PostReported;
use App\Mail\PostReported as PostReportedEmail;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendModeratorsPostReportedEmail implements ShouldQueue
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
    public function handle(PostReported $event): void
    {
        $moderators = User::where('role', 'moderator')->get();
        $user = $event->user;
        if (count($moderators)) {
            foreach ($moderators as $moderator) {
                if ($moderator->id !== $user->id) {
                    // only send email notification to moderator if they aren't the user who 'reported' the content
                    Mail::to($moderator)->queue(new PostReportedEmail($event->topic, $event->post));
                }
            }
        }
    }
}
