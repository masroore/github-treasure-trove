<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class CustomerUser extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'email', 'password', 'status', 'password_reset_at', 'token',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\CustomerAddress');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\CustomerTransaction');
    }
}
