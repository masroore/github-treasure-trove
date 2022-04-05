<?php

namespace App\Notifications;

use App\Http\Resources\AuthorResource;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    protected $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message, User $firstUser)
    {
        $this->message = $message;
        $this->sender = $firstUser;
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

        if ($notifiable->settings['new_message']['email'] ?? false) {
            if (Carbon::parse($this->message->conversation->last_notify_time)->lt(Carbon::now()->subMinutes(5))) {
                $this->message->conversation()->update([
                    'last_notify_time' => Carbon::now(),
                ]);
                $channels[] = 'mail';
            }
        }

        if ($notifiable->settings['new_message']['site'] ?? false) {
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
        $urlName = $this->message->senderData->role;
        if ($urlName === 'admin') {
            $urlName = 'partner';
        }

        $url = config('services.frontUrl') . '/' . $urlName . '/message/' . $this->message->conv_id;

        return (new MailMessage())
            ->view(
                'emails.notifications.message',
                ['entity' => $this->message, 'sender' => $this->sender, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.message.add'))
            ->action(trans('notification.message.action'), $url);
    }

    public function sendPushNotification($notifiable): void
    {
        $urlName = $this->message->senderData->role;
        if ($urlName === 'admin') {
            $urlName = 'partner';
        }
        $url = config('services.frontUrl') . '/' . $urlName . '/message/' . $this->message->conv_id;

        $firebaseToken = [$notifiable->device_token];
        $SERVER_API_KEY = config('services.fcm.key');
        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => trans('notification.message.add'),
                'body' => $this->sender->nickname . ' ' . trans('notification.message.body'),
                'icon' => $this->sender->getAllConversions()['avatar'],
                'action' => $url,
                'click_action' => $url,
                'user' => AuthorResource::make(User::where('id', $this->sender->id)->first()),
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
