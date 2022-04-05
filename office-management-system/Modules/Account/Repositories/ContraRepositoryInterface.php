<?php

namespace Modules\Account\Repositories;

interface ContraRepositoryInterface
{
    public function all();

    public function journal_all();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);
}
