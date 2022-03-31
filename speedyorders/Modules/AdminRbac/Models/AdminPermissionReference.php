<?php

namespace Modules\AdminRbac\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionReference extends Model
{
    protected $table = 'admin_permission_references';

    protected $guarded = [
      'id',
    ];

    public function permissionGroups()
    {
        return $this->hasMany(AdminPermissionGroup::class, 'permission_reference_id');
    }
}
