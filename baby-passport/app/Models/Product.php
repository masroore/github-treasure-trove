<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Product extends Model
{
    protected $table = 'product';

    public $fillable = [
        'product',
        'description',
    ];

    public $casts = [
        'product',
        'description',
    ];

    public static function rules($id = null)
    {
        $unique = empty($id) ? 'unique:product' : 'unique:product,product,' . $id . ',id';

        return [
            'product' => 'required|' . $unique,
            'description' => 'nullable',
        ];
    }

    public function details()
    {
        return $this->hasMany(\App\Models\ProductDetail::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }

    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }
}
