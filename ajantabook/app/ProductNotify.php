<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductNotify extends Model
{
    protected $table = 'product_stock_subscription';

    protected $fillable = ['email', 'user_id', 'var_id'];
}
