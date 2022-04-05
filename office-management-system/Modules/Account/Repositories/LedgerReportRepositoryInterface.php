<?php

namespace Modules\Account\Repositories;

interface LedgerReportRepositoryInterface
{
    public function search($dateFrom, $dateTo, $account_id);

    public function balanceBeforeDate($dateFrom, $beforedateAccount);
}
