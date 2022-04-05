<?php

namespace Modules\Contact\Repositories;

interface ContactRepositoriesInterface
{
    public function all();

    public function serachBasedSupplier($search_keyword);

    public function serachBasedCustomer($search_keyword);

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function supplier();

    public function aciveSupplier();

    public function customer();

    public function witoutWalkInCustomer();

    public function posCustomer();

    public function statusChange(array $data);

    public function csv_contact_upload($data);

    public function create_chart_account($data);
}
