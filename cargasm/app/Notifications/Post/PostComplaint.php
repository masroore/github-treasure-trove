<?php

namespace App\Notifications\Post;

use App\Models\Complaint;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostComplaint extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    protected $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Complaint $complaint)
    {
        $this->post = $post;
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
        $url = config('services.frontUrl') . '/posts/' . $this->post->slug;

        return (new MailMessage())
            ->view(
                'emails.notifications.complaint.complaint',
                ['entity' => $this->post, 'complaint' => $this->complaint, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.complaint.title'))
            ->action(trans('notification.blog.action'), $url);
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
