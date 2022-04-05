<?php

namespace Modules\Account\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\Expense;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }

    public function referable()
    {
        return $this->morphTo();
    }

    public function debitTransactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }

    public function creditTransactions()
    {
        return $this->morphMany(Transaction::class, 'voucherable');
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }

    public function expense()
    {
        return $this->hasOne(Expense::class);
    }

    public function getVoucherTypeIdAttribute()
    {
        switch ($this->voucher_type) {
            case 'CV':
                return 1;

                break;
            case 'BV':
                return 2;

                break;
            case 'JV':
                return 3;

                break;
            case 'CRV':
                return 4;

                break;
            default:
                return 0;

                break;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($category): void {
            $category->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($category): void {
            $category->updated_by = Auth::user()->id ?? null;
        });
    }

    public function scopeExpense($query, $type)
    {
        if ($type == 'today') {
            return $query->whereDate('date', Carbon::today());
        }
        if ($type == 'week') {
            return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        if ($type == 'month') {
            return $query->whereMonth('date', Carbon::now());
        }
        if ($type == 'year') {
            $time_period = TimePeriodAccount::where('is_closed', 0)->latest()->first();

            return $query->whereBetween('date', [$time_period->start_date, $time_period->end_date]);
        }

        return $query;
    }
}
