<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRoleModified extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $old_role;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(string $old_role, User $user)
    {
        $this->old_role = $old_role;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.userModified', [
            'old_role' => $this->old_role,
            'user' => $this->user,
        ]);
    }
}
