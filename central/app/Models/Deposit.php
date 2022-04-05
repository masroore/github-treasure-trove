<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'ct_users_deposit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'wallet_addr',
        'type',
        'amount',
        'deposit_fee',
        'transfer_fee',
        'gas_price',
        'gas_used',
        'tx_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
    ];
}
