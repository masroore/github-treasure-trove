<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'store_id',
        'name',
        'icon',
        'description',
        'status',
        'image',
    ];

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id');
        //->with('subcategories');
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }

    public function vouchers()
    {
        return $this->morphMany('App\Models\DiscountVoucher', 'voucherable');
    }
}
