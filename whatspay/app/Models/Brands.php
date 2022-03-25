<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'website',
        'logo',
        'status',
        'is_featured',
    ];

    protected $hidden = ['pivot'];

    public function products()
    {
        return $this->hasMany(Products::class, 'brand_id')->where('is_variation', 0);
    }
}
