<?php

namespace App\Notifications;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserComplaint extends Notification implements ShouldQueue
{
    use Queueable;

    protected $visitor;

    protected $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $visitor, Complaint $complaint)
    {
        $this->visitor = $visitor;
        $this->complaint = $complaint;
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
        $url = config('services.frontUrl') . '/profile/' . $this->visitor->id . '/main';

        return (new MailMessage())
            ->view(
                'emails.notifications.complaint.complaint',
                ['entity' => $this->visitor, 'complaint' => $this->complaint, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.complaint.title'))
            ->action(trans('notification.user.action'), $url);
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
