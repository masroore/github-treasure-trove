<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'ct_users_login_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip_addr',
        'device',
        'platform',
        'region',
        'accessed_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
