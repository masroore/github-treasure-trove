<?php

namespace Modules\AdminRbac\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUserGroup extends Model
{
    protected $table = 'admin_user_groups';

    protected $guarded = [
        'id',
    ];

    public function group()
    {
        return $this->belongsTo(AdminGroup::class, 'group_id');
    }
}
