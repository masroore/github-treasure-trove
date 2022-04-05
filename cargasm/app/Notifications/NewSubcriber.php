<?php

namespace App\Notifications;

use App\Http\Resources\AuthorResource;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubcriber extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscriber;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscriber)
    {
        $this->subscriber = $subscriber;
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

        if ($notifiable->settings['subscriptions']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['subscriptions']['site'] ?? false) {
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
        $url = config('services.frontUrl');

        return (new MailMessage())
            ->view(
                'emails.notifications.subscribe',
                ['user' => $this->subscriber->user, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.subscription.title'))
            ->action(trans('notification.subscription.site'), $url);
    }

    public function sendPushNotification($notifiable): void
    {
        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $url = config('services.frontUrl');

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.subscription.title'),
                'body' => $this->subscriber->user->name . ' ' . trans('notification.subscription.subscribe'),
                'icon' => $this->subscriber->user->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->subscriber->user->id)->first()),
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
//        dd($response);
    }
}
