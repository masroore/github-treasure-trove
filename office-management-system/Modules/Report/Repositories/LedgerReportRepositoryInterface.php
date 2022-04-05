<?php

namespace Modules\Report\Repositories;

interface LedgerReportRepositoryInterface
{
    public function search($dateFrom, $dateTo, $account_id);

    public function balanceBeforeDate($dateFrom, $beforedateAccount);
}
