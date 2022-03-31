<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Illuminate\Support\Facades\DB;

class UpdateCODSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            Option::set('cod_enable_status', $validatedData['cod_enable_status']);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
