<?php

namespace Modules\Account\Repositories;

interface TransactionRepositoryInterface
{
    public function all();

    public function search($dateFrom, $dateTo, $voucher_type, $payment_type, $is_approve, $account_type);
}
