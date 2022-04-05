<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Setting\Model\EmailTemplate;

class TeamInviteMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public $team;

    public $authUser;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $team, $authUser)
    {
        $this->user = $user;
        $this->team = $team;
        $this->authUser = $authUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tamplate = EmailTemplate::where('type', 'team_member_invitation')->first();

        $subject = $tamplate->subject;
        $body = $tamplate->value;

        $name = $this->user->name ?? $this->user->email;
        $authUser = $this->authUser->name ?? $this->authUser->email;
        $key = ['{INVITATION_SENT_BY}', '{USER_NAME}', '{TEAM_NAME}', 'http://{TEAM_URL}', '{EMAIL_SIGNATURE}', '{EMAIL_FOOTER}'];
        $value = [$authUser, $name, $this->team->name, route('team.show', $this->team->id), app('general_setting')->mail_signature, app('general_setting')->mail_footer];
        $body = str_replace($key, $value, $body);

        return $this->view('project::mail.teaminvite')->with(['body' => $body])->subject($subject);
    }
}
