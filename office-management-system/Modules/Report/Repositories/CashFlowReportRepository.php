<?php

namespace Modules\Report\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Account\Entities\Transaction;

class CashFlowReportRepository implements CashFlowReportRepositoryInterface
{
    public function payments($dateFrom, $dateTo)
    {
        $payments = Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($dateFrom, $dateTo): void {
            $query->where('payment_type', 'voucher_payment')->whereBetween('date', [$dateFrom, $dateTo])->whereHas('transactions');
        })
            ->with(['voucher', 'voucher.transactions', 'account'])
            ->latest()->get();

        return $payments;
    }

    public function recieves($dateFrom, $dateTo)
    {
        $recieves = Transaction::whereHasMorph('voucherable', '*', function (Builder $query) use ($dateFrom, $dateTo): void {
            $query->where('payment_type', 'voucher_recieve')->whereBetween('date', [$dateFrom, $dateTo])->whereHas('transactions');
        })
            ->with(['voucher', 'voucher.transactions', 'account'])
            ->latest()->get();

        return $recieves;
    }
}
