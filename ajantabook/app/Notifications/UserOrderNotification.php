<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserOrderNotification extends Notification
{
    use Queueable;

    public $order_id;

    public $orderiddb;

    /**
     * Create a new notification instance.
     */
    public function __construct($order_id, $orderiddb)
    {
        $this->order_id = $order_id;
        $this->orderiddb = $orderiddb;
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

            'data' => 'Your order #' . $this->orderiddb . ' placed successfully !',
            'n_type' => 'order',
            'url' => $this->order_id,

        ];
    }
}
