<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku', 'name', 'description', 'price', 'quantity', 'min_quantity', 'subtract_stock', 'sort_order', 'status',
        'meta_title', 'meta_description', 'category_id', 'image', 'video',
    ];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
}
