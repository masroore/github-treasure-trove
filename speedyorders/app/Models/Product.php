<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'id', 'uuid', 'sku', 'name', 'slug', 'description', 'base_price', 'sale_price', 'length', 'breadth', 'height', 'width', 'quantity', 'min_quantity', 'subtract_stock', 'sort_order', 'status', 'available', 'meta_title', 'meta_description', 'meta_keywords', 'return_policy_days', 'category_id', 'image', 'video', 'trending', 'is_featured',
    ];

    public function scopeProductDeleteStatus($query)
    {
        return $query->where('deleted_at', null);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id');
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'product_coupons')->withPivot(['status']);
    }

    public function excludedCoupons()
    {
        return $this->belongsToMany(Coupon::class, 'product_coupon_excludes')->withPivot(['status']);
    }

    public function delivery_time()
    {
        return $this->hasMany(ProductDeliveryTime::class, 'products_id');
    }

    public function relatedProducts()
    {
        return $this->hasMany(ProductRelatedProduct::class, 'product_id');
    }

    public function groups()
    {
        return $this->hasMany(ProductGroup::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_products')->withPivot('id', 'sku', 'quantity', 'price', 'tax');
    }

    public function scopeWithFilter($query, $request)
    {
        $categories = $request->category ?? [];

        return $query->when($categories, function ($query) use ($categories) {
            $products = ProductCategory::whereIn('category_id', $categories)->pluck('product_id')->get();

            return $query->whereIn('id', $products)->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }
}
