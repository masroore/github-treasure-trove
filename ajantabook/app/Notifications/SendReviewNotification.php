<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendReviewNotification extends Notification
{
    use Queueable;

    public $pro;

    public $msg;

    /**
     * Create a new notification instance.
     */
    public function __construct($pro, $msg)
    {
        $this->pro = $pro;
        $this->msg = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [

            'data' => $this->msg . ' ' . $this->pro,
            'n_type' => 'order_v',
            'url' => 'admin/review_approval',

        ];
    }
}
