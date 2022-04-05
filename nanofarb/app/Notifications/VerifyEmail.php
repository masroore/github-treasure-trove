<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends \Illuminate\Auth\Notifications\VerifyEmail
{
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage())
            ->subject('Подтверждение адреса электронной почты')
            ->line('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
            ->action('Подтверждение адреса электронной почты', $this->verificationUrl($notifiable))
            ->line('Если вы не создавали учетную запись, просто проигнорируйте это письмо.');
    }
}
