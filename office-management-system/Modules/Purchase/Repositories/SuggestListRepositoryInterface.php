<?php

namespace Modules\Purchase\Repositories;

interface SuggestListRepositoryInterface
{
    public function all();

    public function create($id);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
