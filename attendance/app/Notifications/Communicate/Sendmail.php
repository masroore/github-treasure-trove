<?php

namespace App\Notifications\Communicate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Sendmail extends Notification implements ShouldQueue
{
    use Queueable;
    public $compose;
    public $html;
    public $fullpath;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($compose, $html, $fullpath)
    {
        $this->compose = $compose;
        $this->html = $html;
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
            ->subject($this->compose)
            ->line('Mail From Oguses School Management System')
            ->line($this->html)
            ->attach($this->fullpath)
            ->line('Thank you for choosing OSMS');
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
