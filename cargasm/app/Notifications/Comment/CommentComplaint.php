<?php

namespace App\Notifications\Comment;

use App\Models\Comment;
use App\Models\Complaint;
use App\Models\Event;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentComplaint extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    protected $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, Complaint $complaint)
    {
        $this->comment = $comment;
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
        $url = config('services.frontUrl');
        if ($this->comment->commentable instanceof Rating) {
            $rating = Rating::findOrFail($this->comment->commentable->id);
            $service = Service::findOrFail($rating->service_id);
            $url = $url . '/sto/' . $service->slug;
        } elseif ($this->comment->commentable instanceof Event) {
            $event = Event::findOrFail($this->comment->commentable->id);
            $url = $url . '/events/' . $event->slug;
        } elseif ($this->comment->commentable instanceof Post) {
            $post = Post::findOrFail($this->comment->commentable->id);
            $url = $url . '/' . $post->type . '/' . $post->slug;
        }

        return (new MailMessage())
            ->view(
                'emails.notifications.complaint.complaint',
                ['entity' => $this->comment, 'complaint' => $this->complaint, 'textTeam' => trans('auth.mail.team')]
            )
            ->greeting(trans('notification.complaint.title'))
            ->action(trans('notification.service.action'), $url);
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
