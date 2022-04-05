<?php

namespace App\Notifications\Event;

use App\Http\Resources\AuthorResource;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    protected $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, Comment $comment)
    {
        $this->event = $event;
        $this->comment = $comment;
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

        if ($notifiable->settings['event']['comment']['email'] ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->settings['event']['comment']['site'] ?? false) {
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
                'emails.notifications.comment',
                ['comment' => $this->comment, 'entity' => $this->event, 'sender' => $this->comment->user, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.comment.add'))
            ->action(trans('notification.event.action'), $url);
    }

    public function sendPushNotification($notifiable): void
    {
        $url = config('services.frontUrl') . '/events/' . $this->event->slug;

        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');
        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.comment.add'),
                'body' => $this->comment->user->nickname . ' ' . trans('notification.comment.body') . $this->event->title,
                'icon' => $this->comment->user->getAllConversions()['avatar'],
                'action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->comment->user_id)->first()),
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }
}
