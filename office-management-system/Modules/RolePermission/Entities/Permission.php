<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function scopeModule($query): void
    {
        $query->where(function ($query): void {
            $query->where('route', 'LIKE', '%index%')->orWhere('route', 'LIKE', '%store%')->orWhere('route', 'LIKE', '%create%');
        });
    }
}
