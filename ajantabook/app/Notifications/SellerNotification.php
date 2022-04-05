<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SellerNotification extends Notification
{
    use Queueable;

    public $url;

    public $msg;

    /**
     * Create a new notification instance.
     */
    public function __construct($url, $msg)
    {
        $this->msg = $msg;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class]; //<-- important custom Channel defined here
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [

            'data' => $this->msg,
            'n_type' => 'order_v',
            'url' => $this->url,

        ];
    }
}
