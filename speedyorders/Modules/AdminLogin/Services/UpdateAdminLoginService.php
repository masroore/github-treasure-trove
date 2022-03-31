<?php

namespace Modules\AdminLogin\Services;

class UpdateAdminLoginService
{
    public function handle(array $validatedDatas)
    {
        try {
            DB::beginTransaction();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
