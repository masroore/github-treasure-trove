<?php

namespace Modules\Account\Repositories;

interface TransferRepositoryInterface
{
    public function indexList();

    public function all();

    public function allShowroomAccounts();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);
}
