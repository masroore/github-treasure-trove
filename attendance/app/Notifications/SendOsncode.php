<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOsncode extends Notification implements ShouldQueue
{
    use Queueable;

    private $fullname;

    private $osncode;

    private $email;

    private $phone;

    private $prog;

    /**
     * Create a new notification instance.
     */
    public function __construct($fullname, $osncode, $email, $phone, $prog)
    {
        $this->fullname = $fullname;
        $this->osncode = $osncode;
        $this->email = $email;
        $this->phone = $phone;
        $this->prog = $prog;
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
            ->subject('OSN PAYMENT CODE')
            ->from('ogusesitsolutions@gmail.com')
            ->line("{$this->fullname} Your purchase for osn code has been success, Your osn code for your online registeration is {$this->osncode}, programme is {$this->prog}")
            ->action('Proceed to Online Registeration', route('online-admission-login'))
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
