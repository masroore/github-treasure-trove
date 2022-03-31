<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['product_id', 'category_id'];

    public function product()
    {
        return $this->belongsTo('products', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo('categories', 'category_id');
    }
}
