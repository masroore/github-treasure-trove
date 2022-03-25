<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddOns extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'product_id',
    ];
}
