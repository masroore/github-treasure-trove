<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VeriationItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_variation_items';

    protected $fillable = ['attribute_id', 'variation_id'];
}
