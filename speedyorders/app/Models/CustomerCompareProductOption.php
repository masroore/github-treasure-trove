<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompareProductOption extends Model
{
    protected $fillable = ['customer_compare_product_id', 'product_option_id', 'product_option_value_id', 'product_option_value'];

    public function productOptionValue()
    {
        return $this->belongsTo(ProductOptionValue::class, 'product_option_value_id');
    }

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }
}
