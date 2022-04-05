<?php

namespace Modules\Account\Repositories;

interface ChartAccountRepositoryInterface
{
    public function all($start_date, $end_date);

    public function assetAccountList($timePeriod);

    public function liabilityAccountList($timePeriod);

    public function expenseAccountList($timePeriod);

    public function incomeAccountList($timePeriod);

    public function getAllContacts();

    public function parentNullAccountList();

    public function parent_category();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function incomeAccounts();

    public function getFirst($type, $id);

    public function getPaymentAccountList();

    public function rename_account(array $data);
}
