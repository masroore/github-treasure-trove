<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Vaults\Vault;
use Illuminate\Auth\Access\HandlesAuthorization;

class VaultPolicy
{
    use HandlesAuthorization;

    /**
     * Policy for athorizing Vault modifications.
     */
    public function update(User $user, Vault $vault)
    {
        return $vault->user_id == $user->id;
    }
}
