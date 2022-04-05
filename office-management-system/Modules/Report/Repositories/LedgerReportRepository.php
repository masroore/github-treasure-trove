<?php

namespace Modules\Report\Repositories;

use Modules\Account\Entities\Transaction;

class LedgerReportRepository implements LedgerReportRepositoryInterface
{
    public function search($dateFrom, $dateTo, $account_id)
    {
        $conditions = [];
        if ($account_id != null) {
            $conditions = array_merge($conditions, ['account_id' => $account_id]);
        }

        if ($dateFrom != null && $dateTo != null) {
            $results = Transaction::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])->where($conditions)
                ->with(['voucherable', 'voucherable.transactions', 'account'])
                ->latest()->get();
        } else {
            $results = Transaction::where($conditions)
                ->with(['voucherable', 'voucherable.transactions', 'account'])
                ->latest()->get();
        }

        return $results;
    }

    public function balanceBeforeDate($dateFrom, $beforedateAccount)
    {
        $beforeDateTransactions = Transaction::where('account_id', $beforedateAccount['id'])->where('created_at', '<', $dateFrom . ' 23:59:59')->latest()->get();
        if ($beforedateAccount->type == 1 || $beforedateAccount->type == 4) {
            $balance = $beforeDateTransactions->where('type', 'Dr')->sum('amount') - $beforeDateTransactions->where('type', 'Cr')->sum('amount');
        } else {
            $balance = $beforeDateTransactions->where('type', 'Cr')->sum('amount') - $beforeDateTransactions->where('type', 'Dr')->sum('amount');
        }

        return $balance;
    }
}
