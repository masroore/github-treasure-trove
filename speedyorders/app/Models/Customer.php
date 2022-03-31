<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'telephone', 'newsletter', 'safe', 'status',
        'customer_user_id', 'phone', 'date_of_birth',
    ];

    // public function addresses()
    // {
    //     return $this->hasMany('App\Models\CustomerAddress');
    // }

    public function customers()
    {
        return $this->belongsToMany('App\Models\CouponHistory');
    }

    public function customerUser()
    {
        return $this->belongsTo('App\Models\CustomerUser');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\CustomerAddress', 'customer_user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\CustomerTransaction', 'customer_user_id', 'id');
    }

    public function ips()
    {
        return $this->hasMany('App\Models\CustomerIpAddress', 'customer_id', 'id');
    }
}
