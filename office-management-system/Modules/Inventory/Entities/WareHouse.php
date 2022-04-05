<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductHistory;
use Modules\Purchase\Entities\CostOfGoodHistory;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Quotation\Entities\Quotation;
use Modules\Sale\Entities\Sale;

class WareHouse extends Model
{
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchases()
    {
        return $this->morphMany(PurchaseOrder::class, 'purchasable');
    }

    public function sales()
    {
        return $this->morphMany(Sale::class, 'saleable');
    }

    public function stores()
    {
        return $this->morphMany(CostOfGoodHistory::class, 'storeable');
    }

    public function sends()
    {
        return $this->morphMany(StockTransfer::class, 'sendable');
    }

    public function receives()
    {
        return $this->morphMany(StockTransfer::class, 'receivable');
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function items()
    {
        return $this->morphMany(ProductHistory::class, 'itemable');
    }

    public function quotations()
    {
        return $this->morphMany(Quotation::class, 'quotationable');
    }

    public function stocks()
    {
        return $this->morphMany(StockReport::class, 'houseable');
    }

    public function adjusts()
    {
        return $this->morphMany(StockAdjustment::class, 'adjustable');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($warehouse): void {
            $warehouse->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($warehouse): void {
            $warehouse->updated_by = Auth::user()->id ?? null;
        });
    }
}
