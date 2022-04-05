<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;

class OfferPushNotifications extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }

    public function toOneSignal($notifiable)
    {
        if ('yes' == $this->data['buttonChecked']) {
            return OneSignalMessage::create()
                ->subject($this->data['subject'])
                ->body($this->data['body'])
                ->setIcon($this->data['icon'] ?? '')
                ->setUrl($this->data['target_url'] ?? '#')
                ->setImageAttachments($this->data['image'] ?? '')
                ->webButton(
                    OneSignalWebButton::create('btn-1')
                        ->text($this->data['button_text'])
                        ->url($this->data['button_url'] ?? '#')
                );
        }

        return OneSignalMessage::create()
            ->subject($this->data['subject'])
            ->body($this->data['body'])
            ->setIcon($this->data['icon'] ?? '')
            ->setUrl($this->data['target_url'] ?? '#')
            ->setImageAttachments($this->data['image'] ?? '');
    }
}
