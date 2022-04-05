<?php

namespace App\Notifications\Event;

use App\Http\Resources\AuthorResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StartingSoon extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
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
        $channels = [];

        if ($notifiable->settings['event']['reminder']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['event']['reminder']['site'] ?? false) {
            $this->sendPushNotification($notifiable);
        }

        return $channels;
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
        $url = url(config('services.frontUrl') . '/events/' . $this->event->slug);

        return (new MailMessage())
            ->view(
                'emails.notifications.event.reminder',
                ['event' => $this->event, 'user' => $notifiable]
            )
            ->greeting(trans('notification.event.reminder.title'))
            ->action(trans('notification.event.action'), $url)
            ->line(trans('notification.event.reminder.body'));
    }

    public function sendPushNotification($notifiable): void
    {
        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');
        $url = url(config('services.frontUrl') . '/events/' . $this->event->slug);
        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.event.reminder.title'),
                'body' => trans('notification.event.reminder.body'),
                'icon' => $notifiable->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->event->user_id)->first()),
            ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    }
}
