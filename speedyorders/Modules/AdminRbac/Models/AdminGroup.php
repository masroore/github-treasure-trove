<?php

namespace Modules\AdminRbac\Models;

use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    protected $table = 'admin_groups';

    protected $guarded = ['id'];

    public function users(): void
    {
//        return $this->belongsToMany(AdminU)
    }
}
