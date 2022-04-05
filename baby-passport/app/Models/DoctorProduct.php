<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProduct extends Model
{
    protected $table = 'doctor_product';

    public $timestamps;

    public $fillable = [
        'user_id',
        'product',
        'price',
    ];

    public $casts = [
        'user_id' => 'integer',
        'product' => 'string',
        'price' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
