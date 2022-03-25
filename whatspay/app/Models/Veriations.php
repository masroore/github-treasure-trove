<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veriations extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_variations';
    protected $fillable = ['configurable_product_id', 'product_id', 'is_default'];
}
