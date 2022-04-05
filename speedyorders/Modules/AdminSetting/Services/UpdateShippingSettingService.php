<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateShippingSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            Option::set('ups_live_username', $validatedData['ups_live_username']);
            Option::set('ups_live_password', $validatedData['ups_live_password']);
            Option::set('ups_live_api_key', $validatedData['ups_live_api_key']);
            Option::set('ups_sandbox_username', $validatedData['ups_sandbox_username']);
            Option::set('ups_sandbox_password', $validatedData['ups_sandbox_password']);
            Option::set('ups_sandbox_api_key', $validatedData['ups_sandbox_api_key']);
            Option::set('ups_api_mode', $validatedData['ups_api_mode']);
            Option::set('box_length', $validatedData['box_length']);
            Option::set('box_breadth', $validatedData['box_breadth']);
            Option::set('box_height', $validatedData['box_height']);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
