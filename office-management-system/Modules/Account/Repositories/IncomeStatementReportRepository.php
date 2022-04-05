<?php

namespace Modules\Account\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Entities\Transaction;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Sale\Entities\Sale;

class IncomeStatementReportRepository implements IncomeStatementReportRepositoryInterface
{
    public function search($timePeriod)
    {
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->end_date) {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, $accountingPeriod->end_date]);
            })->sum('amount');
        } else {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, Carbon::now()->toDateString()]);
            })->sum('amount');
        }
    }

    public function saleTransactionBalance($timePeriod)
    {
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->end_date) {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, $accountingPeriod->end_date]);
            })->where('account_id', 15)->sum('amount');
        } else {
            $end_date = Carbon::now()->toDateString();

            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod, $end_date): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, $end_date]);
            })->where('account_id', 15)->sum('amount');
        }
    }

    public function costFoGoodsTransactionBalance($timePeriod)
    {
        $accountingPeriod = TimePeriodAccount::findOrFail($timePeriod);
        if ($accountingPeriod->end_date) {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, $accountingPeriod->end_date]);
            })->where('account_id', 19)->where('type', 'Dr')->sum('amount');
        } else {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, Carbon::now()->toDateString()]);
            })->where('account_id', 19)->where('type', 'Dr')->sum('amount');
        }
    }

    public function TransactionBalance($account_id, $type)
    {
        $accountingPeriod = TimePeriodAccount::where('is_closed', 0)->first();
        if ($accountingPeriod->end_date) {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, $accountingPeriod->end_date]);
            })->where('account_id', $account_id)->where('type', $type)->sum('amount');
        } else {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereBetween('date', [$accountingPeriod->start_date, Carbon::now()->toDateString()]);
            })->where('account_id', $account_id)->where('type', $type)->sum('amount');
        }
    }

    public function TransactionBalanceBranch($account_id, $type)
    {
        $accountingPeriod = TimePeriodAccount::where('is_closed', 0)->first();
        if ($accountingPeriod->end_date) {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereHasMorph('referable', Sale::class, function ($query): void {
                    $query->where('saleable_id', session()->get('showroom_id'))->where('saleable_type', ShowRoom::class);
                })->whereBetween('date', [$accountingPeriod->start_date, $accountingPeriod->end_date]);
            })->where('account_id', $account_id)->where('type', $type)->sum('amount');
        } else {
            return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($accountingPeriod): void {
                $query->where('is_approve', 1)->whereHasMorph('referable', Sale::class, function ($query): void {
                    $query->where('saleable_id', session()->get('showroom_id'))->where('saleable_type', ShowRoom::class);
                })->whereBetween('date', [$accountingPeriod->start_date, Carbon::now()->toDateString()]);
            })->where('account_id', $account_id)->where('type', $type)->sum('amount');
        }
    }

    public function DateWiseTransactionBalanceBranch($account_id, $date)
    {
        return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($date): void {
            $query->where('is_approve', 1)->where('date', $date);
        })->whereIn('account_id', $account_id)->get();
    }

    public function DateRangeWiseTransactionBalanceBranch($account_id, $startDate, $endDate)
    {
        return Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($startDate, $endDate): void {
            $query->where('is_approve', 1)->whereBetween('date', [$startDate, $endDate]);
        })->whereIn('account_id', $account_id)->get();
    }
}
