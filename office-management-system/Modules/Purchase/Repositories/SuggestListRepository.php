<?php

namespace Modules\Purchase\Repositories;

use Modules\Inventory\Entities\ShowRoom;
use Modules\Purchase\Entities\SuggestLists;

class SuggestListRepository implements SuggestListRepositoryInterface
{
    public function all()
    {
        return SuggestLists::with('houseable', 'productSku.product')->where('houseable_id', session()->get('showroom_id'))
            ->where('houseable_type', 'Modules\Inventory\Entities\ShowRoom')->latest()->get();
    }

    public function create($id)
    {
        $showroom = ShowRoom::find(session()->get('showroom_id'));

        $showroom->suggestLists()->create(['product_sku_id' => $id]);

        return $showroom;
    }

    public function find($id)
    {
        return SuggestLists::with('productSku.product')->findOrFail($id);
    }

    public function update(array $data, $id): void
    {
    }

    public function delete($id)
    {
        return SuggestLists::destroy($id);
    }
}
