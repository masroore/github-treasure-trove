<?php

namespace App\Notifications\Wallet;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Walletmail extends Notification
{
    use Queueable;

    public $name;
    public $transctionid;
    public $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $transctionid, $amount)
    {
        $this->name = $name;
        $this->transctionid = $transctionid;
        $this->amount = $amount;
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
            ->subject('Wallet TopUp Notice')
            ->from('ogusesitsolutions@gmail.com')
            ->line("Hello {$this->name}, Your Wallet Has Been Credited with an amount of {$this->amount}")
            ->line("Your Transaction ID is  {$this->transctionid}")
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
