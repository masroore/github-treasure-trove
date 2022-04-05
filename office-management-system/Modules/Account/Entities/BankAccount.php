<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['bank_name', 'branch_name', 'account_name', 'account_no', 'description'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'chart_account_id');
    }

    public function getBalanceAmountAttribute()
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->sum('amount') - $this->transactions->where('type', 'Cr')->sum('amount');
        }

        return $this->transactions->where('type', 'Cr')->sum('amount') - $this->transactions->where('type', 'Dr')->sum('amount');
    }

    public function chartAccount()
    {
        return $this->belongsTo(ChartAccount::class);
    }
}
