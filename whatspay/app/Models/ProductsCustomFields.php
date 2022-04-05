<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsCustomFields extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products_custom_fields';

    protected $fillable = [
        'product_id',
        'label',
        'value',
    ];
}
