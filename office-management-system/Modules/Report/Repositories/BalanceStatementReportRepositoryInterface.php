<?php

namespace Modules\Report\Repositories;

interface BalanceStatementReportRepositoryInterface
{
    public function openingBalancesList($timePeriod);
}
