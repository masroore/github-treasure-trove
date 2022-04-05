<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class ContraVoucher extends Model
{
    protected $table = 'contra_vouchers';

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }
}
