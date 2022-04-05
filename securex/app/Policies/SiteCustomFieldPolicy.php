<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Vaults\SiteCustomField;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteCustomFieldPolicy
{
    use HandlesAuthorization;

    /**
     * Policy for athorizing Site Custom Field modifications.
     */
    public function update(User $user, SiteCustomField $field)
    {
        return $field->site->vault->user_id == $user->id;
    }
}
