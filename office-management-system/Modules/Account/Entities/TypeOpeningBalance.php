<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class TypeOpeningBalance extends Model
{
    protected $table = 'type_opening_balances';

    protected $guarded = ['id'];

    public function chartAccount()
    {
        return $this->belongsTo(ChartAccount::class, 'account_id');
    }
}
