<?php

namespace Modules\AdminStateTax\Services;

use App\Models\StateTaxManager;
use Illuminate\Support\Facades\DB;

class CreateStateTaxService
{
    public function handle(array $validatedDatas)
    {
        try {
            DB::beginTransaction();

            StateTaxManager::create($validatedDatas);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
