<?php

namespace App\Mail\Alerts;

use App\Models\Users\User;
use App\Models\Vaults\Vault;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class VaultDeleted extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Vault $vault)
    {
        $this->user = $user;
        $this->vault = $vault;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Lang::get('mails.alert.account.vault_deleted.subject', ['vault' => $this->vault->name]))
            ->with(['user' => $this->user, 'vault' => $this->vault])
            ->markdown('mails.alerts.vault-deleted');
    }
}
