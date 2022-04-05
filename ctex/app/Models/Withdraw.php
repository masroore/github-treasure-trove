<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'lk_users_withdraw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency',
        'destination',
        'type',
        'amount',
        'withdraw_fee',
        'transfer_fee',
        'gas_price',
        'gas_used',
        'tx_id',
        'status',
        'remark',
    ];

    protected $hidden = [
        'created_at',
    ];
}
