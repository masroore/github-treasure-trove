<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingPackage;
use Illuminate\Support\Facades\DB;
use Log;

class CreatePackageService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            // update all packages as not default when current project set as active
            /*if(isset($validatedData['is_default']) && $validatedData['is_default']==1){
                $affectedRows = ShippingPackage::where('id', '>', 0)->update(array('is_default' => 0));
            }*/

            $package = ShippingPackage::create($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Error' . $e->getMessage());
            DB::rollback();

            return false;
        }
    }
}
