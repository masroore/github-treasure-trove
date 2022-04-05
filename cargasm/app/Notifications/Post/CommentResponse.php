<?php

namespace App\Notifications\Post;

use App\Http\Resources\AuthorResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentResponse extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    protected $commentResponse;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, Comment $commentResponse)
    {
        $this->comment = $comment;
        $this->commentResponse = $commentResponse;
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
        $commentType = '';
        if ($this->comment->commentable_type === 'App\Models\Post') {
            $commentType = 'blog';
        }
        if ($this->comment->commentable_type === 'App\Models\Event') {
            $commentType = 'event';
        }

        $channels = [];
        if ($notifiable->settings[$commentType]['comment_response']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings[$commentType]['comment_response']['site'] ?? false) {
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
        $urlName = '';
        $urlType = '';
        $entity = $this->commentResponse->commentable;

        if ($entity instanceof \App\Models\Post) {
            $urlName = $this->commentResponse->commentable->post_type === 'blog' ? 'blogs' : 'news';
            $urlType = $this->commentResponse->commentable->id;
        }
        if ($entity instanceof \App\Models\Event) {
            $urlName = 'events';
            $urlType = $this->commentResponse->commentable->slug;
        }

        $url = config('services.frontUrl') . '/' . $urlName . '/' . $urlType;

        return (new MailMessage())
            ->view(
                'emails.notifications.comment',
                ['comment' => $this->commentResponse, 'entity' => $entity, 'sender' => $this->commentResponse->user, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.comment.response'))
            ->action(trans('notification.comment.action_response'), $url);
    }

    public function sendPushNotification($notifiable): void
    {
        $urlName = '';
        $urlType = '';
        $entity = $this->commentResponse->commentable;

        if ($entity instanceof \App\Models\Post) {
            $urlName = $this->commentResponse->commentable->post_type === 'blog' ? 'blogs' : 'news';
            $urlType = $this->commentResponse->commentable->slug;
        }
        if ($entity instanceof \App\Models\Event) {
            $urlName = 'events';
            $urlType = $this->commentResponse->commentable->slug;
        }

        $url = config('services.frontUrl') . '/' . $urlName . '/' . $urlType;

        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.comment.response'),
                'body' => $this->commentResponse->user->name . ' ' . trans('notification.comment.answer') . ' ' . $this->comment->text,
                'icon' => $this->comment->user->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->commentResponse->user_id)->first()),
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
