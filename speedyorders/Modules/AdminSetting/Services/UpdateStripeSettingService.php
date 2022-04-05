<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateStripeSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Option::set('stripe_payment_mode', $validatedData['stripe_payment_mode']);
            Option::set('stripe_key', $validatedData['stripe_key']);
            Option::set('stripe_secret', $validatedData['stripe_secret']);
            Option::set('live_stripe_key', $validatedData['live_stripe_key']);
            Option::set('live_stripe_secret', $validatedData['live_stripe_secret']);
            Option::set('stripe_enable_status', $validatedData['stripe_enable_status']);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
