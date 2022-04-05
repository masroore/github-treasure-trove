<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;

class ReceiveProduct extends Model
{
    protected $fillable = [];

    public function item()
    {
        return $this->hasOne(ProductItemDetail::class, 'product_sku_id', 'product_sku_id')->where('itemable_id', $this->purchase_id)
            ->where('itemable_type', PurchaseOrder::class);
    }
}
