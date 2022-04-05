<?php

namespace Modules\Account\Repositories;

interface BankAccountRepositoryInterface
{
    public function all($start_date = null, $end_date = null);

    public function create(array $data);

    public function find($id);

    public function update(array $data);

    public function delete($id);

    public function csv_upload_bank_account($data);

    public function create_chart_account($bankAccount, $chart_account);
}
