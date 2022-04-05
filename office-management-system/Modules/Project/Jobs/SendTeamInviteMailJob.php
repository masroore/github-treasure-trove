<?php

namespace Modules\Project\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\Project\Emails\TeamInviteMail;

class SendTeamInviteMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $user;

    protected $team;

    protected $authUser;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $team, $authUser)
    {
        $this->user = $user;
        $this->team = $team;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new TeamInviteMail($this->user, $this->team, $this->authUser));
    }
}
