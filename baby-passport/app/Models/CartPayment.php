<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class CartPayment extends Model
{
    protected $table = 'cart_payment';

    public $fillable = [
        'cart_id',
        'payment_type',
        'payment_uuid',
        'old_balance',
        'description',
        'subtotal',
        'iva',
        'total',
        'new_balance',
        'receipt',
        'created_at',
        'updated_at',

    ];

    public $casts = [
        'cart_id' => 'integer',
        'payment_type' => 'string',
        'payment_uuid' => 'string',
        'old_balance' => 'numeric',
        'description' => 'string',
        'subtotal' => 'numeric',
        'iva' => 'numeric',
        'total' => 'numeric',
        'new_balance' => 'numeric',
        'receipt' => 'string',

    ];

    public function cart()
    {
        return $this->belongsTo(\App\Models\Cart::class);
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
