<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LocalPickUpNotification extends Notification
{
    use Queueable;

    public $productname;

    public $var_main;

    public $order_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($productname, $var_main, $order_id)
    {
        $this->productname = $productname;
        $this->var_main = $var_main;
        $this->order_id = $order_id;
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
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [

            'data' => 'For Item ' . $this->productname . '( ' . $this->var_main . ' ) Local Pickup date is updated',
            'n_type' => 'order',
            'url' => $this->order_id,

        ];
    }
}
