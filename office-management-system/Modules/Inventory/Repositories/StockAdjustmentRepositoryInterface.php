<?php

namespace Modules\Inventory\Repositories;

interface StockAdjustmentRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function statusChange($id);

    public function update(array $data, $id);

    public function delete($id);

    public function checkQuantity($data);
}
