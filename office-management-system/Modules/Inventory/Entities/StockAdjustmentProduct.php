<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductSku;

class StockAdjustmentProduct extends Model
{
    protected $table = 'stock_adjustment_products';

    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($stock_adjustment_product): void {
            $stock_adjustment_product->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($stock_adjustment_product): void {
            $stock_adjustment_product->updated_by = Auth::user()->id ?? null;
        });
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }
}
