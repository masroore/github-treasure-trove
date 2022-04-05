<?php

namespace App\Notifications\Post;

use App\Http\Resources\AuthorResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLike extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Like $like, User $user)
    {
        $this->post = $post;
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
        if ($notifiable->settings['blog']['like']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['blog']['like']['site'] ?? false) {
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
                'emails.notifications.like',
                ['entity' => $this->post, 'user' => $this->user]
            )
            ->greeting(trans('notification.event.like.add'))
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
                'title' => trans('notification.blog.like.add'),
                'body' => $this->user->nickname . ' ' . trans('notification.blog.like.body') . ' ' . $this->post->title,
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

//    public function toWebPush($notifiable, $notification)
//    {
//        return (new WebPushMessage())
//            ->title(trans('notification.blog.like.add'))
//            ->body($notifiable->nickname . trans('notification.blog.like.body') . $notification->post->title )
//            ->action(trans('notification.blog.like.add'), url(env('FRONT_URL') . 'posts/' . $notification->post->id))
//            ->options(['TTL' => 1000]);
//    }

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
