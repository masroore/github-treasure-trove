<?php

namespace Modules\Setup\Repositories;

interface TaxRepositoryInterface
{
    public function all();

    public function activeTax();

    public function serachBased($search_keyword);

    public function create(array $data);

    public function update_status(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
