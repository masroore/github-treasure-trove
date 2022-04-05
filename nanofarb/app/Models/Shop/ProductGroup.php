<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * All products for self variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_group_id');
    }

    /**
     * Default product for self variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'default_product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function reviews()
    {
        return $this->hasManyThrough(ProductReview::class, Product::class)
            ->orderBy('created_at', 'desc');
    }
}
