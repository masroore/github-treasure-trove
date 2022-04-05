<?php

namespace App\Notifications\Event;

use App\Http\Resources\AuthorResource;
use App\Models\Event;
use App\Models\Like;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLike extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, Like $like, User $user)
    {
        $this->event = $event;
        $this->like = $like;
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
        if ($notifiable->settings['event']['like']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['event']['like']['site'] ?? false) {
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
        $url = config('services.frontUrl') . '/events/' . $this->event->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.like',
                ['entity' => $this->event, 'user' => $this->user]
            )
            ->greeting(trans('notification.event.like.add'))
            ->action(trans('notification.event.action'), $url)
            ->line(trans('notification.event.application.body'));
    }

    public function sendPushNotification($notifiable): void
    {
        $url = config('services.frontUrl') . '/events/' . $this->event->slug;

        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.event.like.add'),
                'body' => $this->user->nickname . ' ' . trans('notification.event.like.body') . ' ' . $this->event->title,
                'icon' => $this->user->getAllConversions()['avatar'],
                'action' => $url,
                'click_action' => $url,
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
}
