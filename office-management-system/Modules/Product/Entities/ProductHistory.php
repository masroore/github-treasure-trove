<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\StockReport;

class ProductHistory extends Model
{
    protected $guarded = [];

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

    public function houseable()
    {
        return $this->morphTo();
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function stock()
    {
        return $this->hasOne(StockReport::class, 'houseable_id', 'itemable_id')->where('houseable_type', $this->itemable_type)
            ->where('product_sku_id', $this->product_sku_id);
    }
}
