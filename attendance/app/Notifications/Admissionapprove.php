<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Admissionapprove extends Notification implements ShouldQueue
{
    use Queueable;

    public $fullname;
    public $level;
    public $prog;
    public $file;
    public $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fullname, $level, $prog, $session, $file)
    {
        $this->fullname = $fullname;
        $this->level = $level;
        $this->prog = $prog;
        $this->session = $session;
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
            ->subject('Addmission Approved')
            ->from('ogusesitsolutions@gmail.com')
            ->line("{$this->fullname} Congratulation upon successful admission. You have gain admission to {$this->level} {$this->session} to read {$this->prog}")
            ->action('Print Student Guidelines', route('online-admission-login'))
            ->line('find attached Student Guidelines')
            ->attach($this->file)
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
