<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = [
        'id',
        'product_option_id',
        'option_id',
        'option_value_id',
        'quantity',
        'subtract_from_stock',
        'price',
        'price_prefix',
        'input_value',
        'status',
    ];

    protected function productOption()
    {
        return $this->belongsTo(productOption::class, 'product_option_id');
    }

    protected function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    protected function optionValue()
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id');
    }
}
