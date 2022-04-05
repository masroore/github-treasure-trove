<?php

namespace App\Notifications;

use Closure;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Modules\Setting\Model\EmailTemplate;

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
     * @param mixed $notifiable
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
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }
        $tamplate = EmailTemplate::where('type', 'email_confirmation')->first();
        $subject = $tamplate->subject;
        $body = $tamplate->value;

        $appName = config('settings.site_title') ?? 'Infix Biz';
        $key = ['http://VERIFY_URL', 'http://{VERIFY_URL}', '{VERIFY_URL}', '{APP_NAME}', '{APP_NAME}', '{APP_NAME}', '{EMAIL_FOOTER}', '{EMAIL_SIGNATURE}'];
        $value = [$verificationUrl, $verificationUrl, $verificationUrl, $appName, '', ''];
        $body = str_replace($key, $value, $body);

        return (new MailMessage())
            ->view('mail.body', ['body' => $body])->subject($subject);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
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
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param Closure $callback
     */
    public static function toMailUsing($callback): void
    {
        static::$toMailCallback = $callback;
    }
}
