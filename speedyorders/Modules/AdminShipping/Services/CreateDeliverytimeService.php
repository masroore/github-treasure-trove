<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingDeliveryTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;

class CreateDeliverytimeService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            $package = ShippingDeliveryTime::create($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            Log::info('Error' . $e->getMessage());
            DB::rollback();

            return false;
        }
    }
}
