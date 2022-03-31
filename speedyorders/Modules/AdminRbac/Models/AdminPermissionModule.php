<?php

namespace Modules\AdminRbac\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionModule extends Model
{
    protected $table = 'admin_permission_modules';

    protected $guarded = [
        'id',
    ];

    public function permissionReferences()
    {
        return $this->hasMany(AdminPermissionReference::class, 'permission_modules_id');
    }
}
