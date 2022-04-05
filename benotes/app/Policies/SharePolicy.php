<?php

namespace App\Policies;

use App\Share;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class SharePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the share.
     *
     * @return mixed
     */
    public function delete(User $user, Share $share)
    {
        return $user->id === $share->created_by;
    }
}
