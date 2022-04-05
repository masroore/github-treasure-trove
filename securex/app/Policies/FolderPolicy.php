<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Vaults\Folder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * Policy for athorizing Folder modifications.
     */
    public function update(User $user, Folder $folder)
    {
        return $folder->vault->user_id == $user->id;
    }
}
