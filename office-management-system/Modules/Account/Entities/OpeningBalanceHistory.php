<?php

namespace Modules\Account\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class OpeningBalanceHistory extends Model
{
    protected $table = 'opening_balance_histories';

    protected $guarded = ['id'];

    public function time_period_account()
    {
        return $this->belongsTo(TimePeriodAccount::class, 'time_period_account_id')->withDefault();
    }

    public function account()
    {
        return $this->belongsTo(ChartAccount::class, 'account_id', 'id')->withDefault();
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($modal): void {
            $modal->created_by = Auth::user()->id ?? null;
        });

        static::created(function ($modal): void {
            $modal->code = Auth::user()->id ?? null;
        });

        static::updating(function ($modal): void {
            $modal->updated_by = Auth::user()->id ?? null;
        });
    }
}
