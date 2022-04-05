<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

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
        $token = $this->token;

        return (new MailMessage())->view('auth.passwords.email-code', compact('token'));
        // ->greeting('¡Hola!')
            // ->subject('Reinicio de contraseña')
            // ->line('Esta recibiendo este correo porque se ha pedido reiniciar la contraseña desde su cuenta.')
            // ->action('Reiniciar contrasesña', url('password/reset', $this->token))
            // ->line('Si usted no pidio reiniciar la contraseña, no necesita realizar ninguna acción.');
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
