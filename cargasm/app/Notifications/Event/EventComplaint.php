<?php

namespace App\Notifications\Event;

use App\Models\Complaint;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventComplaint extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    protected $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, Complaint $complaint)
    {
        $this->event = $event;
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
        $url = config('services.frontUrl') . '/event/' . $this->event->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.complaint.complaint',
                ['entity' => $this->event, 'complaint' => $this->complaint, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.complaint.title'))
            ->action(trans('notification.event.action'), $url);
    }
}
