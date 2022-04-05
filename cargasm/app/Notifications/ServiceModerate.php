<?php

namespace App\Notifications;

use App\Http\Resources\AuthorResource;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ServiceModerate extends Notification implements ShouldQueue
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
        $this->sendPushNotification($notifiable);
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
    }

    public function sendPushNotification($notifiable): void
    {
        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $urlName = $this->service->user->role;
        if ($urlName === 'admin') {
            $urlName = 'partner';
        }

        $url = config('services.frontUrl') . '/' . $urlName . '/sto';

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.services.title'),
                'body' => trans('notification.services.body'),
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
