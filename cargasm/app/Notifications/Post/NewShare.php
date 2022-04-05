<?php

namespace App\Notifications\Post;

use App\Http\Resources\AuthorResource;
use App\Models\Post;
use App\Models\Share;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewShare extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    protected $share;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Share $share)
    {
        $this->post = $post;
        $this->share = $share;
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
        if ($notifiable->settings['blog']['share']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['blog']['share']['site'] ?? false) {
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
        $urlName = $this->post->post_type === 'blog' ? 'blogs' : 'news';

        $url = config('services.frontUrl') . '/' . $urlName . '/' . $this->post->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.share',
                ['entity' => $this->post, 'user' => $this->share->user]
            )
            ->greeting(trans('notification.blog.share.add'))
            ->action(trans('notification.blog.action'), $url)
            ->line(trans('notification.event.application.body'));
    }

    public function sendPushNotification($notifiable): void
    {
        $urlName = $this->post->post_type === 'blog' ? 'blogs' : 'news';

        $url = config('services.frontUrl') . '/' . $urlName . '/' . $this->post->slug;

        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.blog.share.add'),
                'body' => $this->share->user->name . ' ' . trans('notification.blog.share.body') . ' ' . $this->post->title,
                'icon' => $this->share->user->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->share->user_id)->first()),
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
