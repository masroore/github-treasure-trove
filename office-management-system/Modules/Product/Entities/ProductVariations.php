<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductVariations extends Model
{
    protected $table = 'product_variations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'variant_id',
        'variant_value_id',
        'image_source',
        'created_by',
        'updated_by',
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

    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id');
    }

    public function variation_value()
    {
        return $this->belongsTo(VariantValues::class, 'variant_value_id');
    }
}
