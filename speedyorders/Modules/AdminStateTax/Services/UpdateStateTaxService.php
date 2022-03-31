<?php

namespace Modules\AdminStateTax\Services;

use App\Models\StateTaxManager;
use Illuminate\Support\Facades\DB;

class UpdateStateTaxService
{
    public function handle(array $validatedDatas, $id)
    {
        try {
            DB::beginTransaction();

            $tax = StateTaxManager::find($id);

            $tax->update($validatedDatas);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
