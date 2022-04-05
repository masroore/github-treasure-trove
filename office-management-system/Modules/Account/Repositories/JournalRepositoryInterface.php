<?php

namespace Modules\Account\Repositories;

interface JournalRepositoryInterface
{
    public function all();

    public function transactionalAccounts();

    public function journal_all();

    public function create(array $data);

    public function find($id);

    public function expenseAccounts();

    public function update(array $data, $id);
}
