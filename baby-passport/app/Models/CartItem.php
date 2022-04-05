<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';

    public $timestamps = false;

    public $fillable = [
        'cart_id',
        'hospital_product_id',
        'quantity',
        'discount',
        'total',
    ];

    public $casts = [
        'cart_id' => 'integer',
        'hospital_product_id' => 'integer',
        'quantity' => 'integer',
        'discount' => 'float',
        'total' => 'float',
    ];

    public function cart()
    {
        return $this->belongsTo(\App\Models\Cart::class);
    }

    public function hospitalProduct()
    {
        return $this->belongsTo(\App\Models\HospitalProduct::class);
    }
}
