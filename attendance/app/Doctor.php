<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'address', 'phone', 'category',
    ];

    public function user()
    {
        return $this->belongsto('APP\User');
    }

    public function bookings()
    {
        return $this->hasMany('APP\Booking');
    }
}
