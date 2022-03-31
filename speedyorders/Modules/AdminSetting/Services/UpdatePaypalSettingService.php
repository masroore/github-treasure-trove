<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Illuminate\Support\Facades\DB;

class UpdatePaypalSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            Option::set('paypal_live_client_id', $validatedData['paypal_live_client_id']);
            Option::set('paypal_live_secret_key', $validatedData['paypal_live_secret_key']);
            Option::set('papapal_live_currency', $validatedData['papapal_live_currency']);
            Option::set('paypal_sandbox_client_id', $validatedData['paypal_sandbox_client_id']);
            Option::set('paypal_sandbox_secret_key', $validatedData['paypal_sandbox_secret_key']);
            Option::set('paypal_sandbox_currency', $validatedData['paypal_sandbox_currency']);
            Option::set('paypal_api_mode', $validatedData['paypal_api_mode']);
            Option::set('paypal_enable_status', $validatedData['paypal_enable_status']);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
