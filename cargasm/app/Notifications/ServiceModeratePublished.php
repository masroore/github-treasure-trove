<?php

namespace App\Notifications;

use App\Http\Resources\AuthorResource;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceModeratePublished extends Notification implements ShouldQueue
{
    use Queueable;

    protected $service;

    /**
     * Create a new notification instance.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
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
        $channels[] = 'mail';
        $this->sendPushNotification($notifiable);

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
        $url = config('services.frontUrl') . '/sto/' . $this->service->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.services.moderate',
                ['service' => $this->service, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.services.status_published'))
            ->action(trans('notification.services.action'), $url);
    }

    public function sendPushNotification($notifiable): void
    {
        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $url = config('services.frontUrl') . '/sto/' . $this->service->slug;

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.services.published'),
                'body' => trans('notification.services.published'),
                'icon' => $notifiable->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make($notifiable),
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
}
