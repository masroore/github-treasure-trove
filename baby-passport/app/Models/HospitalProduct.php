<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalProduct extends Model
{
    protected $table = 'hospital_product';

    public $fillable = [
        'hospital_id',
        'product_id',
        'price',
        'deposit',
    ];

    public $casts = [
        'hospital_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'float',
        'deposit' => 'float',

    ];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
