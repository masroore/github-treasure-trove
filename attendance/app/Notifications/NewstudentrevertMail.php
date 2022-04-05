<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewstudentrevertMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $fullname;

    public $regemail;

    /**
     * Create a new notification instance.
     */
    public function __construct($fullname, $regemail)
    {
        $this->fullname = $fullname;
        $this->regemail = $regemail;
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
            ->subject('OSMS ADMISSION REVOCKED')
            ->from('ogusesitsolutions@gmail.com')
            ->line("Dear {$this->fullname},")
            ->line('I Hope this mail finds you well.')
            ->line('Please your admission has been revocked due to certain reasons unknown to management.')
            ->line('You will get an email to notify you if your admission is reconsidered by management.')
            ->line('For more info, please visit the admission office for more info.')
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
