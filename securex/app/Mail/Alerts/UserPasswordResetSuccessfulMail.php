<?php

namespace App\Mail\Alerts;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class UserPasswordResetSuccessfulMail extends Mailable
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
        return $this->subject(Lang::get('mails.alert.account.password_reset_success.subject'))
            ->with(['user' => $this->user])
            ->markdown('mails.alerts.user-password-reset-successful');
    }
}
