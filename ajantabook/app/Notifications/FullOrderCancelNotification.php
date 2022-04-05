<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FullOrderCancelNotification extends Notification
{
    use Queueable;

    public $inv_cus;

    public $order_id;

    public $mstatus;

    /**
     * Create a new notification instance.
     */
    public function __construct($inv_cus, $order_id, $mstatus)
    {
        $this->inv_cus = $inv_cus;
        $this->order_id = $order_id;
        $this->mstatus = $mstatus;
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

    public function toDatabase($notifiable)
    {
        return [

            'data' => 'Your Order #' . $this->inv_cus->order_prefix . $this->order_id . ' has been ' . $this->mstatus,
            'n_type' => 'order',
            'url' => $this->order_id,

        ];
    }
}
