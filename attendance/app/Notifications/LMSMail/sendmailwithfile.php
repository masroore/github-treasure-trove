<?php

namespace App\Notifications\LMSMail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendmailwithfile extends Notification
{
    use Queueable;

    public $subject;

    public $compose;

    public $studntgroup;

    public $fullpath;

    public $from;

    public $fremail;

    /**
     * Create a new notification instance.
     */
    public function __construct($from, $fremail, $subject, $compose, $studntgroup, $fullpath)
    {
        $this->from = $from;
        $this->fremail = $fremail;
        $this->subject = $subject;
        $this->compose = $compose;
        $this->studntgroup = $studntgroup;
        $this->fullpath = $fullpath;
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
            ->from($this->from)
            ->replyTo($this->fremail)
            ->line($this->compose)
            ->attach($this->fullpath)
            ->line('Thank you for choosing OSMS!');
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
