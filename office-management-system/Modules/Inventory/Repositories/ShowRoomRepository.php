<?php

namespace Modules\Inventory\Repositories;

use Modules\Account\Entities\ChartAccount;
use Modules\Inventory\Entities\ShowRoom;

class ShowRoomRepository implements ShowRoomRepositoryInterface
{
    public function all()
    {
        return ShowRoom::with('stocks', 'contact')->latest()->get();
    }

    public function serachBased($search_keyword)
    {
        return ShowRoom::whereLike(['name', 'email', 'address', 'phone'], $search_keyword)->get();
    }

    public function activeShoowroom()
    {
        return ShowRoom::latest()->active()->get();
    }

    public function create(array $data)
    {
        $warehouse = new ShowRoom();
        $warehouse->fill($data)->save();
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $warehouse->name . '(Cash)';
        $chart_account->description = null;
        $chart_account->configuration_group_id = 1;
        $chart_account->status = 1;
        $chart_account->parent_id = 1;
        $chart_account->type = 1;
        $chart_account->contactable_type = get_class(new ShowRoom());
        $chart_account->contactable_id = $warehouse->id;
        $chart_account->save();
        ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . sprintf('%02d', $chart_account->parent_id) . '-' . $chart_account->id]);

        return $warehouse;
    }

    public function find($id)
    {
        return ShowRoom::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $warehouse = ShowRoom::findOrFail($id);

        $warehouse->update($data);
    }

    public function delete($id)
    {
        return ShowRoom::findOrFail($id)->delete();
    }
}
