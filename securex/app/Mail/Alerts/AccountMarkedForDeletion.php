<?php

namespace App\Mail\Alerts;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class AccountMarkedForDeletion extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Lang::get('mails.alert.account.marked_deletion.subject'))
            ->with(['user' => $this->user])
            ->markdown('mails.alerts.account-marked-for-deletion');
    }
}
