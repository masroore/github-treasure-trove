<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductOption extends Model
{
    protected $table = 'order_product_option';

    protected $fillable = [
        'order_id',
        'order_product_id',
        'product_option_id',
        'product_option_value_id',
        'value',
        'type',
    ];

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }

    public function productOptionValue()
    {
        return $this->belongsTo(ProductOptionValue::class);
    }
}
