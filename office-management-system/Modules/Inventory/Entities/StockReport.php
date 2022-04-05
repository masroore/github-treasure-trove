<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\ProductSku;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Purchase\Entities\PurchaseOrder;

class StockReport extends Model
{
    protected $fillable = ['stock', 'product_sku_id', 'stock_date', 'houseable_id', 'houseable_type'];

    public function houseable()
    {
        return $this->morphTo();
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function suggestProducts()
    {
        return $this->hasMany(ProductSku::class, 'id', 'product_sku_id');
    }

    public function purchase()
    {
        return $this->hasOne(PurchaseOrder::class, 'purchasable_type', 'houseable_type')->latest()->where('purchasable_id', $this->houseable_id);
    }

    public function items()
    {
        return $this->hasMany(ProductItemDetail::class, 'product_sku_id', 'product_sku_id');
    }

    public function scopeSupplier($query, $supplier)
    {
        return $query->whereHas('items', function ($query) use ($supplier): void {
            $query->whereHasMorph('itemable', PurchaseOrder::class, function ($query) use ($supplier): void {
                $query->where('supplier_id', $supplier);
            });
        });
    }

    public function scopeProductSku($query, $product_sku_id)
    {
        return $query->whereHas('items', function ($query) use ($product_sku_id): void {
            $query->where('itemable_type', PurchaseOrder::class)->where('product_sku_id', $product_sku_id);
        });
    }

    public function scopeBrandProduct($query, $brand_id)
    {
        return $query->whereHas('items', function ($query) use ($brand_id): void {
            $query->where('itemable_type', PurchaseOrder::class)->whereHas('productSku', function ($query) use ($brand_id): void {
                $query->whereHas('product', function ($query) use ($brand_id): void {
                    $query->where('brand_id', $brand_id);
                });
            });
        });
    }
}
