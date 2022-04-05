<?php

namespace App\Notifications\User;

use App\Models\Vaults\Vault;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VaultDeleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vault;

    /**
     * Create a new notification instance.
     */
    public function __construct(Vault $vault)
    {
        $this->vault = $vault;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        $message = $this->vault->name . ' Vault Deleted';

        return [
            'message' => $message,
            'type' => 'danger',
            'url' => '/vaults',
        ];
    }
}
