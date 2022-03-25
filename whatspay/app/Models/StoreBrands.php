<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBrands extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'brand_id',
        'status',
    ];
}
