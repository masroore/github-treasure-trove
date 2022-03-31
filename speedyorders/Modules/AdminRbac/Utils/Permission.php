<?php

namespace Modules\AdminRbac\Utils;

use Auth;
use Modules\AdminRbac\Models\AdminPermissionReference;

class Permission
{
    private static $groups;
    private static $instance;

    private function __construct()
    {
    }

    public static function __init()
    {
        if (!isset(self::$groups)) {
            self::$instance = new self();
            self::$instance->__loadPermissions();
        }

        return self::$instance;
    }

    private function __loadPermissions()
    {
        $permissionRefs = AdminPermissionReference::with('permissionGroups')->get();
        $groupIds = [];
        foreach ($permissionRefs as $permissionRef) {
            $groupIds[$permissionRef->code] = $permissionRef->permissionGroups ? $permissionRef->permissionGroups->pluck('group_id')->toArray() : [];
        }
        self::$groups = $groupIds;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', \E_USER_ERROR);
    }

    // CHECKING USER PERMISSION TO ACCESS THE MODULE
    public static function check($moduleName = null)
    {
        try {
            if (null == $moduleName) {
                return false;
            }
            if (!Auth::guard('admin')->check()) {
                return false;
            }
            // if super admin return true;
            if (Auth::guard('admin')->user()->isSuperadmin->count() > 0) {
                return true;
            }
            if (!isset(self::$groups)) {
                self::__init();
            }
            //if module name does not exists in permission reference table
            if (!\array_key_exists($moduleName, self::$groups)) {
                return false;
            }
            $permissionGroupIds = self::$groups[$moduleName];
            $userGrpIds = Auth::guard('admin')->user()->user_group ? Auth::guard('admin')->user()->user_group->pluck('group_id')->toArray() : [];

            return \count(array_intersect($permissionGroupIds, $userGrpIds)) > 0 ? true : false;
        } catch (\Exception $e) {
            dd($e);

            return false;
        }
    }
}
