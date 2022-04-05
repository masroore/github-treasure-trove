<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposable extends Model
{
    protected $table = 'ct_users_disposable';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'wallet_address',
        'wallet_privkey',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
