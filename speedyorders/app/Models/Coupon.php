<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [''];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_coupons')->withPivot(['status']);
    }

    public function excludedProducts()
    {
        return $this->belongsToMany('App\Models\Product', 'product_coupon_excludes')->withPivot(['status']);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'coupon_categories')->withPivot(['status']);
    }
}
