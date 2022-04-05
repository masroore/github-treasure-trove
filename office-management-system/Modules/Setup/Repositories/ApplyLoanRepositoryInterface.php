<?php

namespace Modules\Setup\Repositories;

interface ApplyLoanRepositoryInterface
{
    public function all();

    public function appliedAll();

    public function create(array $data);

    public function find($id);

    public function staffLoans($id);

    public function update(array $data, $id);

    public function change_approval(array $data);

    public function delete($id);

    public function loanUser();
}
