<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->permissions()->contains('view-users');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create()
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->permissions()->contains('update-users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id === $model->id || $user->permissions()->contains('delete-users');
    }

    /**
     * Determine whether the user can change role.
     *
     * @return bool
     */
    public function changeRole(User $user)
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }
}
