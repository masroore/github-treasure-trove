<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\StockReport;
use Modules\Purchase\Entities\CostOfGoodHistory;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Purchase\Entities\PurchaseOrder;

class ProductSku extends Model
{
    protected $table = 'product_sku';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function product_variation()
    {
        return $this->hasOne(ProductVariations::class);
    }

    public function sku_products()
    {
        return $this->morphMany(ProductItemDetail::class, 'productable');
    }

    public function stocks()
    {
        return $this->hasMany(StockReport::class, 'product_sku_id');
    }

    public function part_numbers()
    {
        return $this->hasMany(PartNumber::class);
    }

    public function costOfGoodsPrices()
    {
        return $this->hasMany(CostOfGoodHistory::class, 'product_sku_id');
    }

    public function suggested()
    {
        return $this->hasOne(StockReport::class, 'product_sku_id')->latest()->where('stock', '=', $this->alert_quantity);
    }

    public function stockShowroom()
    {
        return $this->hasOne(StockReport::class)->where('stock', '>', 0);
    }

    public function scopeHasStock($query)
    {
        return $query->whereHas('stockShowroom');
    }

    public function scopeStockProduct($query, $id, $type)
    {
        return $query->whereHas('stockShowroom', function ($query) use ($id, $type): void {
            $query->where('houseable_id', $id)->where('houseable_type', $type);
        });
    }

    public function scopeSuggestedList($query)
    {
        return $query->whereHas('suggested', function ($q): void {
            $q->whereColumn('stock', '<=', 'alert_quantity');
        });
    }

    public function stock()
    {
        return $this->hasOne(StockReport::class)->latest()->where('houseable_id', session()->get('showroom_id'))->where('houseable_type', 'Modules\Inventory\Entities\ShowRoom');
    }

    public function item()
    {
        return $this->hasOne(ProductItemDetail::class)->latest()->where('itemable_type', PurchaseOrder::class)
            ->orWhere('itemable_type', '=', null);
    }
}
