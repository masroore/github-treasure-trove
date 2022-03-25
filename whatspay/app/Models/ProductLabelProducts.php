<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLabelProducts extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey;
    public $incrementing = false;
    protected $fillable = [
        'product_id',
        'product_label_id',
    ];
}
