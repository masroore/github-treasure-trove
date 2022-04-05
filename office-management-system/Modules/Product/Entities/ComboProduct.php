<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Purchase\Entities\ProductItemDetail;

class ComboProduct extends Model
{
    protected $table = 'combo_products';

    protected $guarded = ['id'];

    public function combo_products()
    {
        return $this->hasMany(ComboProductDetail::class);
    }

    public function sku_combo_products()
    {
        return $this->morphMany(ProductItemDetail::class, 'productable');
    }
}
