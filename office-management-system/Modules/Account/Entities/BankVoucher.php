<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class BankVoucher extends Model
{
    protected $table = 'bank_vouchers';

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }
}
