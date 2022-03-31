<?php

namespace App\Notifications\Quickmail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendquickmailwithfile extends Notification
{
    use Queueable;

    public $to;
    public $subject;
    public $message;
    public $from;
    public $file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $message, $file, $from)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
        $this->file = $file;
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
            ->subject($this->subject)
            ->line($this->message)
            ->replyTo($this->from)
            ->attach($this->file)
            ->line('Thank you!');
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