<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingZonePrice;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateZonepriceService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();

            ShippingZonePrice::where('id', $id)->first()->update($validatedData);
            $zoneprice = ShippingZonePrice::where('id', $id)->first();
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
