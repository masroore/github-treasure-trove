<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompareProduct extends Model
{
    protected $fillable = ['customer_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customerCompareProductOption()
    {
        return $this->hasMany('App\Models\CustomerCompareProductOption');
    }
}
