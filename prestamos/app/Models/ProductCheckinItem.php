<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCheckinItem extends Model
{
    protected $table = 'product_check_in_items';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function items()
    {
        return $this->hasMany(self::class, 'product_check_in_id', 'id');
    }
}
