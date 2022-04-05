<?php

namespace Modules\Setup\Repositories;

use Modules\Account\Entities\ChartAccount;
use Modules\Setup\Entities\Tax;

class TaxRepository implements TaxRepositoryInterface
{
    public function all()
    {
        return Tax::latest()->get();
    }

    public function activeTax()
    {
        return Tax::where('status', 1)->latest()->get();
    }

    public function serachBased($search_keyword)
    {
        return Tax::whereLike(['name', 'description', 'rate'], $search_keyword)->get();
    }

    public function create(array $data): void
    {
        $tax = Tax::create($data);
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $tax->name;
        $chart_account->description = null;
        $chart_account->configuration_group_id = null;
        $chart_account->status = 1;
        $chart_account->parent_id = 5;
        $chart_account->type = 2;
        $chart_account->contactable_type = get_class(new Tax());
        $chart_account->contactable_id = $tax->id;
        $chart_account->save();
        ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . $chart_account->id]);
    }

    public function update_status(array $data)
    {
        return Tax::findOrFail($data['id'])->update($data);
    }

    public function find($id)
    {
        return Tax::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return Tax::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Tax::findOrFail($id)->delete();
    }
}
