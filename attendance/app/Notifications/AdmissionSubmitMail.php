<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdmissionSubmitMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $fullname;

    /**
     * Create a new notification instance.
     */
    public function __construct($fullname)
    {
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
            ->subject('Admission Process Complete')
            ->from('ogusesitsolutions@gmail.com')
            ->line("{$this->fullname} Thank you for choosing Ogua School Management System. Your admission has been submitted successfully.
                        A notification by mail and text will be sent to you when your application has been approved by management.")
            ->action('Check Admission Status Here', route('admission-completed'))
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
