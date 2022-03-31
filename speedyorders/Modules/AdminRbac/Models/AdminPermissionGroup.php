<?php

namespace Modules\AdminRbac\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionGroup extends Model
{
    protected $table = 'admin_permission_groups';

    protected $guarded = [
        'id',
    ];
}
