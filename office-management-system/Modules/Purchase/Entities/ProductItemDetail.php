<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItemDetailPartNumber;
use Modules\Product\Entities\ProductSku;

class ProductItemDetail extends Model
{
    protected $fillable = ['productable_id', 'productable_type', 'product_sku_id', 'price', 'quantity', 'tax', 'discount', 'sub_total', 'part_numbers', 'selling_price'];

    protected $casts = ['received_date' => 'object'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id')->withDefault();
    }

    public function part_number_details()
    {
        return $this->hasMany(ProductItemDetailPartNumber::class);
    }

    public function itemable()
    {
        return $this->morphTo()->withDefault();
    }

    public function productable()
    {
        return $this->morphTo()->withDefault();
    }
}
