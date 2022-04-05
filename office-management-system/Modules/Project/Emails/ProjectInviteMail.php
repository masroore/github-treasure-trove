<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Setting\Model\EmailTemplate;

class ProjectInviteMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $user;

    protected $project;

    protected $authUser;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $project, $authUser)
    {
        $this->user = $user;
        $this->project = $project;
        $this->authUser = $authUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tamplate = EmailTemplate::where('type', 'project_member_invitation')->first();

        $subject = $tamplate->subject;
        $body = $tamplate->value;

        $name = $this->user->name ?? $this->user->email;
        $authUser = $this->authUser->name ?? $this->authUser->email;
        $key = ['{INVITATION_SENT_BY}', '{USER_NAME}', '{PROJECT_NAME}', 'http://{PROJECT_URL}', '{EMAIL_SIGNATURE}', '{EMAIL_FOOTER}', '{PROJECT_URL}'];
        $value = [$authUser, $name, $this->project->name, route('project.show', $this->project->uuid), config('config.mail_signature'), config('config.mail_footer'), route('project.show', $this->project->uuid)];
        $body = str_replace($key, $value, $body);

        return $this->view('project::mail.projectinvite')->with(['body' => $body])->subject($subject);
    }
}
