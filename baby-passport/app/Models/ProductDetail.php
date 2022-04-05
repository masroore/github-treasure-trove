<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_detail';

    public $fillable = [
        'product_id',
        'detail',
    ];

    public $casts = [
        'product_id',
        'detail',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
