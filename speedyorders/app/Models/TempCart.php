<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempCart extends Model
{
    protected $table = 'temp_cart';

    protected $fillable = [
        'php_session_id', 'product_id', 'quantity', 'unit_price', 'created_at',
    ];
}
