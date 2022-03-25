<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'store_id',
        'title',
        'country',
        'city',
        'radius',
        'latitude',
        'longitude',
        'status',
    ];

    // belongs to stores
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    // has many rules
    public function config()
    {
        return $this->hasMany(ShippingRule::class);
    }

    // has many child shippings
    public function cities()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with(['config' => function ($query) {
                $query->select('id', 'shipping_id', 'min', 'max', 'charges');
            }]);
    }
}
