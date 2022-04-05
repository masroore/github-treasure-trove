<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTUser extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_users_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'login_id',
        'email',
        'name',
        'birthday',
        'gender',
        'country',
        'mobile',
        'postal_code',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
