<?php

namespace Modules\AdminRbac\Services;

use App\Models\User;
use Modules\AdminRbac\Models\AdminUserGroup;

abstract class UserService
{
    abstract public function handle(array $data, ?int $id = null);

    protected function addUserGroup(object $user, $groups)
    {
        foreach ($groups as $k => $group) {
            $userGroup[$k]['user_id'] = $user->id;
            $userGroup[$k]['group_id'] = $group;
            $userGroup[$k]['created_at'] = now();
            $userGroup[$k]['updated_at'] = now();
        }

        return AdminUserGroup::insert($userGroup);
    }

    protected function findById(int $id)
    {
        return User::find($id);
    }
}
