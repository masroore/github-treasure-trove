<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Sale\Entities\Sale;

class ProductItemDetailPartNumber extends Model
{
    protected $table = 'product_item_details_part_numbers';

    protected $guarded = ['id'];

    public function product_item_detail()
    {
        return $this->belongsTo(ProductItemDetail::class);
    }

    public function part_number()
    {
        return $this->belongsTo(PartNumber::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
