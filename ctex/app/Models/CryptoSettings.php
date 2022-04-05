<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoSettings extends Model
{
    protected $table = 'lk_crypto_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency',
        'currency_url',
        'name',
        'type',
        'unit',
        'rate_decimals',
        'cashback',
        'min_deposit',
        'min_withdraw',
        'transfer_fee',
        'gas_price',
        'gas_limit',
        'gas',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
