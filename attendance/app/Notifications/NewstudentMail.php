<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewstudentMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $fullname;
    public $regemail;

    /**
     * Create a new notification instance.
     *
     * @return void
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
            ->subject('OSMS ADMISSION')
            ->from('ogusesitsolutions@gmail.com')
            ->line("Dear {$this->fullname},")
            ->line('I Hope this mail finds you well.')
            ->line('OSMS welcomes you to Ogua School Management System. Congratulations upon your admission. Have a nice stay with us.')
            ->line('Your login credential to access the schools portal are: ')
            ->line("Email: {$this->regemail}")
            ->line('password is the email address you provided during registration')
            ->action('Student Portal', route('student-login'))
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
