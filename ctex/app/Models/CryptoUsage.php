<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoUsage extends Model
{
    protected $table = 'lk_crypto_usages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency',
        'use_deposit',
        'use_withdraw',
        'fee_mode',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
