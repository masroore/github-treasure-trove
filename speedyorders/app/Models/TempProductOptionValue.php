<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempProductOptionValue extends Model
{
    protected $table = 'temp_product_option_value';

    protected $fillable = [
        'php_session_id', 'product_id', 'option_id', 'option_value', 'created_at',
    ];
}
