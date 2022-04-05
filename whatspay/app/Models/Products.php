<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

//        protected $with=['variations','productAttributeSets','productLabels'];
    protected $fillable = [
        'name', 'description', 'status', 'sku',
        'price', 'with_storehouse_management', 'quantity',
        'category_id', 'brand_id', 'is_variation', 'sale_type', 'sale_price',
        'start_date', 'end_date', 'images', 'store_id', 'size_chart_id',
    ];

    public function productAttributeSets()
    {
        return $this->belongsToMany(AttributeSet::class, 'product_with_attribute_sets', 'product_id', 'attribute_set_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariations::class, 'configurable_product_id');
    }

    public function parentProduct()
    {
        return $this->belongsToMany(self::class, 'product_variations', 'product_id', 'configurable_product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class)->withDefault();
    }

    public function productLabels()
    {
        return $this->belongsToMany(ProductLabels::class, 'product_label_products', 'product_id', 'product_label_id');
    }

    public function variationAttributeSwatchesForProductList()
    {
        return $this
            ->hasMany(ProductVariations::class, 'configurable_product_id')
            ->join(
                'product_variation_items',
                'product_variation_items.variation_id',
                '=',
                'product_variations.id'
            )
            ->join('product_attributes', 'product_attributes.id', '=', 'product_variation_items.attribute_id')
            ->join(
                'product_attribute_sets',
                'product_attribute_sets.id',
                '=',
                'product_attributes.attribute_set_id'
            )
//            ->where('product_attribute_sets.status', BaseStatusEnum::PUBLISHED)
            ->where('product_attribute_sets.is_use_in_product_listing', 1)
            ->select([
                'product_attributes.*',
                'product_variations.*',
                'product_variation_items.*',
                'product_attribute_sets.*',
                'product_attributes.title as attribute_title',
            ]);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tags::class,
            'product_tags',
            'product_id',
            'tag_id'
        );
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function defaultProductAttributes()
    {
        return $this
            ->belongsToMany(Attribute::class, 'product_with_attributes', 'product_id', 'attribute_id')
            ->join('product_variation_items', 'product_variation_items.attribute_id', '=', 'product_with_attributes.attribute_id')
            ->join('product_variations', function ($join) {
                return $join->on('product_variations.id', '=', 'product_variation_items.variation_id')
                    ->where('product_variations.is_default', 1);
            })
            ->distinct();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function slug()
    {
        return $this->morphOne('App\Models\Slug', 'slugeable');
    }

    /**
     * Get if product is favorite.
     */
    public function favorite()
    {
        return $this->morphOne(Favorites::class, 'favorable');
    }

    public function vouchers()
    {
        return $this->morphMany('App\Models\DiscountVoucher', 'voucherable');
    }
}
