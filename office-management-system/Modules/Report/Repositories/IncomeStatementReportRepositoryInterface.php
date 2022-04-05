<?php

namespace Modules\Report\Repositories;

interface IncomeStatementReportRepositoryInterface
{
    public function search($timePeriod);

    public function saleTransactionBalance($timePeriod);

    public function costFoGoodsTransactionBalance($timePeriod);

    public function TransactionBalance($account_id, $type);

    public function DateWiseTransactionBalanceBranch($account_id, $date);

    public function DateRangeWiseTransactionBalanceBranch($account_id, $startDate, $endDate);
}
