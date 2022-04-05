<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Setting\Model\EmailTemplate;

class PasswordResetNotification extends ResetPassword
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $tamplate = EmailTemplate::where('type', 'password_reset_template')->first();
        $subject = $tamplate->subject;
        $body = $tamplate->value;

        $key = ['http://{RESET_LINK}', '{RESET_LINK}', '{APP_NAME}', '{EMAIL_FOOTER}', '{EMAIL_SIGNATURE}'];
        $value = [route('password.reset', $this->token), route('password.reset', $this->token), config('config.site_name'), '', ''];
        $body = str_replace($key, $value, $body);

        return (new MailMessage())
            ->view('mail.body', ['body' => $body])->subject($subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
