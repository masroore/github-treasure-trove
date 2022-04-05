<?php

namespace Modules\Account\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class TimePeriodAccount extends Model
{
    protected $table = 'time_period_accounts';

    protected $guarded = ['id'];

    public function openning_balance_histories()
    {
        return $this->hasMany(OpeningBalanceHistory::class);
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
