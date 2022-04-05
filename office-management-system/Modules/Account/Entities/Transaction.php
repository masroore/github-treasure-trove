<?php

namespace Modules\Account\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Sale\Entities\Sale;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function voucherable()
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->hasOne(ChartAccount::class, 'id', 'account_id')->withDefault();
    }

    public function fromAccounts()
    {
        return $this->belongsToMany(ChartAccount::class, 'tranaction_account', 'tranaction_id', 'account_id');
    }

    public function scopeApproved($query)
    {
        return $query->whereHasMorph('voucherable', Voucher::class, function ($q): void {
            $q->where('is_approve', 1);
        });
    }

    public function voucher()
    {
        return $this->hasOne(Voucher::class, 'id', 'voucherable_id');
    }

    public function scopeAccount($query, $id)
    {
        if (is_array($id)) {
            return $query->whereIn('account_id', $id);
        }

        return $query->where('account_id', $id);
    }

    public function scopeBalanceAmount($query, $type)
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

    public function scopeShowroom($query)
    {
        if (session()->get('showroom_id') != 1) {
            return $query->whereHasMorph('voucherable', Voucher::class, function ($query): void {
                $query->whereHasMorph('referable', Sale::class, function ($query): void {
                    $query->where('saleable_id', session()->get('showroom_id'))->where('saleable_type', ShowRoom::class);
                });
            });
        } else {
            return $query;
        }
    }
}
