<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price');
    }

    public function getValueSuffixAttribute()
    {
        return $this->value . $this->suffix;
    }
}
