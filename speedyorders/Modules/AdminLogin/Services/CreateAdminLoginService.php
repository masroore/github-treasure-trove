<?php

namespace Modules\AdminLogin\Services;

use Exception;

class CreateAdminLoginService
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
