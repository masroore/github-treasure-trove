<?php

namespace App\Notifications\Announcement;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class notifystudent extends Notification
{
    use Queueable;

    public $students;

    public $title;

    public $message;

    public $from;

    public $fullname;

    /**
     * Create a new notification instance.
     */
    public function __construct($students, $title, $message, $from, $fullname)
    {
        $this->students = $students;
        $this->title = $title;
        $this->message = $message;
        $this->from = $from;
        $this->fullname = $fullname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->from($this->fullname)
            ->replyTo($this->from)
            ->subject($this->title)
            ->line($this->message)
            ->line('Best Regards')
            ->line($this->fullname);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
