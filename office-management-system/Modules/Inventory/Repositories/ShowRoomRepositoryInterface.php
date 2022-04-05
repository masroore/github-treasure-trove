<?php

namespace Modules\Inventory\Repositories;

interface ShowRoomRepositoryInterface
{
    public function all();

    public function serachBased($search_keyword);

    public function activeShoowroom();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);
}
