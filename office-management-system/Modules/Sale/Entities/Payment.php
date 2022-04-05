<?php

namespace Modules\Sale\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\TimePeriodAccount;

class Payment extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['amount' => 'array'];

    protected $table = 'payments';

    public function payable()
    {
        return $this->morphTo();
    }

    public function scopePayment($query, $type)
    {
        if ($type == 'today') {
            return $query->whereDate('created_at', Carbon::today());
        }
        if ($type == 'week') {
            return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        if ($type == 'month') {
            return $query->whereMonth('created_at', Carbon::now());
        }
        if ($type == 'year') {
            $time_period = TimePeriodAccount::where('is_closed', 0)->latest()->first();

            return $query->whereBetween('created_at', [$time_period->start_date, $time_period->end_date]);
        }

        return $query;
    }
}
