<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class MailConfirm extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {

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
        $url = config('services.frontUrl');

        return (new MailMessage())
            ->greeting(trans('auth.mail.congratulation'))
            ->subject(Lang::get('Mail Is Confirmed'))
            ->view('emails.verify', ['firstPart' => trans('auth.mail.body.first_part'), 'secondPart' => trans('auth.mail.body.second_confirm'), 'textTeam' => trans('auth.mail.team')])
            ->action(trans('auth.mail.to_site'), $url);
    }
}
