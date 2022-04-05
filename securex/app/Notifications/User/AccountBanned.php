<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AccountBanned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $remark;

    /**
     * Create a new notification instance.
     */
    public function __construct($remark)
    {
        $this->remark = $remark;
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
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        $message = 'Account Banned by ADMIN for ' . $this->remark;

        return [
            'message' => $message,
            'type' => 'danger',
            'url' => '/profile',
        ];
    }
}
