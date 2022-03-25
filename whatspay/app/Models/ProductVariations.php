<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    use HasFactory;
    //protected $with=['productAttributes','product'];
    //protected $with=['product'];

    protected $fillable = ['configurable_product_id', 'product_id', 'is_default'];

    public function variationItems()
    {
        return $this->hasMany(ProductVariationItems::class, 'variation_id');
    }

    public function variationItemName()
    {
        return $this->hasMany(ProductVariationItems::class, 'variation_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id')->withDefault();
    }

    public function productAttributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'product_variation_items',
            'variation_id',
            'attribute_id'
        );
    }
}
