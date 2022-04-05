<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Services;

use Spatie\Permission\Models\Role;

class RolesService
{
    public static $defaultRoles = ['guest'];

    public static function get()
    {
        $roles = Role::all();
        $result = [];
        foreach ($roles as $role) {
            $result[] = $role->name;
        }
        //return array_merge(self::$defaultRoles, $result);
        return $result;
    }
}
