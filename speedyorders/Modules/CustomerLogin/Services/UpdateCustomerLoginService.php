<?php

namespace Modules\CustomerLogin\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class UpdateCustomerLoginService
{
    public function handle(array $validatedDatas)
    {
        try {
            DB::beginTransaction();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
