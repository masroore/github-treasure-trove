<?php

namespace Modules\Inventory\Repositories;

use Modules\Inventory\Entities\WareHouse;

class WareHouseRepository implements WareHouseRepositoryInterface
{
    public function all()
    {
        return WareHouse::latest()->get();
    }

    public function serachBased($search_keyword)
    {
        return WareHouse::whereLike(['name', 'email', 'address', 'phone'], $search_keyword)->get();
    }

    public function activeWarehouse()
    {
        return WareHouse::latest()->active()->get();
    }

    public function create(array $data)
    {
        $warehouse = new WareHouse();
        $warehouse->fill($data)->save();

        return $warehouse;
    }

    public function find($id)
    {
        return WareHouse::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $warehouse = WareHouse::findOrFail($id);

        $warehouse->update($data);
    }

    public function delete($id)
    {
        return WareHouse::findOrFail($id)->delete();
    }
}
