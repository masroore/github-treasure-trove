<?php

namespace Modules\Account\Repositories;

interface CashbookRepositoryInterface
{
    public function search_credit($date);

    public function search_debit($date);

    public function search($previous_date);
}
