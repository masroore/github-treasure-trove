<?php

namespace Modules\Inventory\Repositories;

interface ExpenseRepositoryInterface
{
    public function expenceList();

    public function expenceAccount();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
