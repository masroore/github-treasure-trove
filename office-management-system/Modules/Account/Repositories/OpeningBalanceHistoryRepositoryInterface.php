<?php

namespace Modules\Account\Repositories;

interface OpeningBalanceHistoryRepositoryInterface
{
    public function all();

    public function assetAccountsAll();

    public function OpeningBalanceHistory($timePeriod);

    public function liabilityAccountsAll();

    public function activeInterval();

    public function create(array $data);

    public function createForUser(array $data);

    public function createForHistory(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function individualUpdate(array $data, $id);

    public function closeStatement($id);

    public function closedBalanceList($is_default, $date);
}
