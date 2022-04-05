<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealGroupDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_group_id',
        'product_id',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'id', 'product_id');
    }
}
