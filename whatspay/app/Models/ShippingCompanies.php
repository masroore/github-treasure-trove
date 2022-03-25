<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompanies extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'image',
        'shipping_service',
        'company_url',
        'tracking_url',
        'address',
        'country',
        'state',
        'city',
        'postal_code',
        'email',
        'status',
        'is_featured',
    ];
}
