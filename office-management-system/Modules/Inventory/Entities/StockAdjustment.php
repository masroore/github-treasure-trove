<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\ProductHistory;

class StockAdjustment extends Model
{
    protected $table = 'stock_adjustments';

    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($stock_adjustment): void {
            $stock_adjustment->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($stock_adjustment): void {
            $stock_adjustment->updated_by = Auth::user()->id ?? null;
        });
    }

    public function items()
    {
        return $this->morphMany(ProductItemDetail::class, 'itemable');
    }

    public function adjustable()
    {
        return $this->morphTo();
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function stock_adjustments_products()
    {
        return $this->hasMany(StockAdjustmentProduct::class);
    }
}
