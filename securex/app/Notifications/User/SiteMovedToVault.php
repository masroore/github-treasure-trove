<?php

namespace App\Notifications\User;

use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SiteMovedToVault extends Notification
{
    use Queueable;

    protected $vault;

    protected $site;

    protected $newVault;

    /**
     * Create a new notification instance.
     */
    public function __construct(Site $site, Vault $vault, Vault $newVault)
    {
        $this->site = $site;
        $this->vault = $vault;
        $this->newVault = $newVault;
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
        $message = $this->site->name . ' Site was moved from ' . $this->vault->name . ' Vault to ' . $this->newVault->name . ' Vault';

        return [
            'message' => $message,
            'type' => 'info',
            'url' => '/vaults',
        ];
    }
}
