<?php

namespace Modules\Report\Repositories;

interface CashFlowReportRepositoryInterface
{
    public function payments($dateFrom, $dateTo);

    public function recieves($dateFrom, $dateTo);
}
