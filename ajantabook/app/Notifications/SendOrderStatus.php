<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOrderStatus extends Notification
{
    use Queueable;

    public $productname;

    public $var_main;

    public $status;

    public $order_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($productname, $var_main, $status, $order_id)
    {
        $this->productname = $productname;
        $this->var_main = $var_main;
        $this->status = $status;
        $this->order_id = $order_id;
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

            'data' => 'Your Item ' . $this->productname . '( ' . $this->var_main . ' ) has been ' . $this->status,
            'n_type' => 'order',
            'url' => $this->order_id,

        ];
    }
}
