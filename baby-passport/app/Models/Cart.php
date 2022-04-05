<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Cart extends Model
{
    protected $table = 'cart';

    public $fillable = [
        'user_id',
        'amount',
        'balance',
    ];

    public $casts = [
        'user_id' => 'integer',
        'amount' => 'float',
        'balance' => 'float',
    ];

    public function items()
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function hospitalSchedule()
    {
        return $this->hasOne(\App\Models\HospitalSchedule::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\CartPayment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }

    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }
}
