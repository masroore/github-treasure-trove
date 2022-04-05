<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ComboProductDetail extends Model
{
    protected $table = 'combo_product_details';

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id');
    }

    public function combo_product()
    {
        return $this->belongsTo(ComboProduct::class, 'combo_product_id');
    }
}
