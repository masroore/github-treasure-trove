<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWithAttributeSet extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_set_id', 'product_id'];
}
