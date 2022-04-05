<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage())
            ->subject('Сброс пароля')
            ->line('Вы получили это письмо, потому что был сделанн запрос на сброс пароля для вашей учетной записи')
            ->action('Восстановить пароль', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line('Срок действия ссылки для сброса пароля истекает через ' . config('auth.passwords.users.expire') . ' минут.')
            ->line('Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.');
    }
}
