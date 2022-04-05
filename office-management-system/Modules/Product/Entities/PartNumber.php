<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class PartNumber extends Model
{
    protected $table = 'part_numbers';

    protected $guarded = [];

    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function product_item_details_part_number()
    {
        return $this->hasOne(ProductItemDetailPartNumber::class, 'part_number_id');
    }
}
