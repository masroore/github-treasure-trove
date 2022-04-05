<?php

namespace Modules\Purchase\Repositories;

use Modules\Purchase\Entities\CNF;

class CNFRepository implements CNFRepositoryInterface
{
    public function all()
    {
        return CNF::latest()->get();
    }

    public function create(array $data): void
    {
        $cnf = new CNF();
        $cnf->fill($data)->save();
    }

    public function find($id)
    {
        return CNF::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $cnf = CNF::findOrFail($id);
        $cnf->update($data);
    }

    public function delete($id)
    {
        return CNF::destroy($id);
    }
}
