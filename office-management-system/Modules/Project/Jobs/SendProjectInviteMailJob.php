<?php

namespace Modules\Project\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\Project\Emails\ProjectInviteMail;

class SendProjectInviteMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $user;

    protected $project;

    protected $authUser;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $project, $authUser)
    {
        $this->user = $user;
        $this->project = $project;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new ProjectInviteMail($this->user, $this->project, $this->authUser));
    }
}
