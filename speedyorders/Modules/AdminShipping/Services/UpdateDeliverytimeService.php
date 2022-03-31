<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingDeliveryTime;
use Illuminate\Support\Facades\DB;

class UpdateDeliverytimeService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            ShippingDeliveryTime::where('id', $id)->first()->update($validatedData);
            $deliverytime = ShippingDeliveryTime::where('id', $id)->first();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
