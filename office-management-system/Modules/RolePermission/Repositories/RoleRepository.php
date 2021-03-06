<?php

namespace Modules\RolePermission\Repositories;

use Modules\RolePermission\Entities\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::orderBy('id', 'desc')->get();
    }

    public function create(array $data): void
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->type = $data['type'];
        $role->save();
    }

    public function update(array $data, $id)
    {
        return Role::findOrFail($id)->update($data);
    }

    public function delete($id): void
    {
        Role::findOrFail($id)->delete();
    }

    public function normalRoles()
    {
        return Role::where('type', '!=', 'system_user')->get();
    }

    public function regularRoles()
    {
        return Role::where('type', 'regular_user')->get();
    }
}
