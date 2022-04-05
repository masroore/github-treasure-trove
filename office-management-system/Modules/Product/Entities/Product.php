<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_name',
        'product_type',
        'model_id',
        'unit_type_id',
        'brand_id',
        'category_id',
        'sub_category_id',
        'origin',
        'description',
        'image_source',
        'created_by',
        'updated_by',
        'price_of_other_currency',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($model): void {
            $model->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($model): void {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function model()
    {
        return $this->belongsTo(ModelType::class, 'model_id');
    }

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariations::class);
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }
}
