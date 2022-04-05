<?php

namespace Modules\Leave\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\Role;

class LeaveDefine extends Model
{
    protected $table = 'leave_defines';

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
