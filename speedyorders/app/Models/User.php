<?php

namespace App\Models;

use App\Utils\Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\AdminRbac\Models\AdminGroup;
use Modules\AdminRbac\Models\AdminUserGroup;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function isSuperAdmin()
    {
        return $this->hasMany(AdminUserGroup::class)->where('group_id', Helper::SUPER_ADMIN_ROLE);
    }

    public function userGroup()
    {
        return $this->hasMany(AdminUserGroup::class);
    }

    public function groups()
    {
        return $this->belongsToMany(AdminGroup::class, 'admin_user_groups', 'user_id', 'group_id');
    }
}
