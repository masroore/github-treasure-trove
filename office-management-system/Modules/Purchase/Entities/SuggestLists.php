<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\ProductSku;

class SuggestLists extends Model
{
    protected $fillable = ['houseable_id', 'houseable_type', 'product_sku_id'];

    public function houseable()
    {
        return $this->morphTo();
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
