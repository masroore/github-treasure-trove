<?php

namespace App\Notifications\Event;

use App\Http\Resources\AuthorResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewParticipant extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
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
        if ($notifiable->settings['event']['new_participant']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['event']['new_participant']['site'] ?? false) {
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
        $urlName = $this->event->user->role;
        if ($urlName === 'admin') {
            $urlName = 'partner';
        }
        $urlName = '/' . $urlName;

        $url = config('services.frontUrl') . $urlName . '/events/' . $this->event->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.event.participant',
                ['event' => $this->event, 'user' => $notifiable]
            )
            ->greeting(trans('notification.event.application.title'))
            ->action(trans('notification.event.action'), $url)
            ->line(trans('notification.event.application.body'));
    }

    public function sendPushNotification($notifiable): void
    {
        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $urlName = $this->event->user->role;
        if ($urlName === 'admin') {
            $urlName = 'partner';
        }
        $urlName = '/' . $urlName;

        $url = url(config('services.frontUrl') . $urlName . '/events/' . $this->event->slug);

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.event.application.title'),
                'body' => trans('notification.event.application.body'),
                'icon' => $notifiable->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make($this->user),
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

        $response = curl_exec($ch);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
