<?php

namespace Modules\Report\Repositories;

use Modules\Account\Entities\Transaction;

class CustomerReportRepository implements CustomerReportRepositoryInterface
{
    public function search($account_id)
    {
        return Transaction::where(['account_id' => $account_id])->latest()->get();
    }
}
