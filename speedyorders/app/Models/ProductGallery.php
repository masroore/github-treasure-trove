<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $fillable = [
        'id', 'product_id', 'image', 'order', 'product_option_value_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
