<?php

namespace Modules\Account\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Entities\Transaction;

class CashbookRepository implements CashbookRepositoryInterface
{
    public function search_credit($date)
    {
        $conditions = [];
        $account_id = ChartAccount::where('contactable_id', session()->get('showroom_id'))->where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')->first()->id;
        $results = Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($account_id, $date): void {
            $query->where('is_approve', 1)->where('date', $date)->whereHas('transactions', function ($query) use ($account_id): void {
                $query->where('account_id', $account_id)->where('type', 'Dr');
            });
        })->whereNotIn('account_id', [$account_id])
            ->with(['voucherable', 'voucherable.transactions', 'account'])
            ->latest()->get();

        return $results;
    }

    public function search_debit($date)
    {
        $conditions = [];
        $account_id = ChartAccount::where('contactable_id', session()->get('showroom_id'))->where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')->first()->id;
        $results = Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($account_id, $date): void {
            $query->where('is_approve', 1)->where('date', $date)->whereHas('transactions', function ($query) use ($account_id): void {
                $query->where('account_id', $account_id)->where('type', 'Cr');
            });
        })->whereNotIn('account_id', [$account_id])
            ->with(['voucherable', 'voucherable.transactions', 'account'])
            ->latest()->get();

        return $results;
    }

    public function search($previous_date)
    {
        $conditions = [];
        $start_date = TimePeriodAccount::where('is_closed', 0)->latest()->first()->start_date;
        $account_id = ChartAccount::where('contactable_id', session()->get('showroom_id'))->where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')->first()->id;
        $results = Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($account_id, $previous_date, $start_date): void {
            $query->where('is_approve', 1)->whereBetween('created_at', [$start_date . ' 00:00:00', $previous_date . ' 23:59:59'])->whereHas('transactions', function ($query) use ($account_id): void {
                $query->where('account_id', $account_id);
            });
        })->whereNotIn('account_id', [$account_id])
            ->with(['voucherable', 'voucherable.transactions', 'account'])
            ->latest()->get();

        return $results;
    }
}
