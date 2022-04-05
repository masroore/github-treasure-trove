<?php

namespace App\Listeners;

use App\Events\UsersPasswordReset;
use App\Mail\PasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class SendPasswordResets implements ShouldQueue
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
    public function handle(UsersPasswordReset $event): void
    {
        foreach ($event->users as $user) {
            // Password::sendResetLink(['email' => $user->email]);
            Mail::to($user)->send(new PasswordMail(base64_encode(explode(' ', trim(strtolower($user->name)))[0])));
        }
    }
}
