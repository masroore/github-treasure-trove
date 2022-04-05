<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Vaults\Site;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Policy for athorizing Site modifications.
     */
    public function update(User $user, Site $site)
    {
        return $site->user_id == $user->id;
    }
}
