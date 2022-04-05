<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class JournalVoucher extends Model
{
    protected $table = 'journal_vouchers';

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }
}
