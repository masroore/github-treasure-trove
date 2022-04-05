<?php

namespace App\Notifications;

use App\Models\User;
use Closure;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var null|Closure
     */
    public static $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage())
            ->greeting(trans('auth.mail.title'))
            ->subject(Lang::get('Verify Email Address'))
            ->view('emails.verify', ['firstPart' => trans('auth.mail.body.first_part'), 'secondPart' => trans('auth.mail.body.second_part'), 'textTeam' => trans('auth.mail.team')])
            ->action(trans('auth.mail.confirm'), $verificationUrl);
    }

    protected function getAuthToken(User $user)
    {
        $token = $user->createToken('token');

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
        ];
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     *
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
                'status' => 'success',
                'title' => trans('auth.mail.congratulation'),
                'message' => trans('system.email.verify_success'),
                'role' => $notifiable->role,
                'token' => $this->getAuthToken($notifiable),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  Closure  $callback
     */
    public static function toMailUsing($callback): void
    {
        static::$toMailCallback = $callback;
    }
}
