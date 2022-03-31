<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingPackage;
use Illuminate\Support\Facades\DB;

class UpdatePackageService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            // update all packages as not default when current project set as active
            /*if(isset($validatedData['is_default']) && $validatedData['is_default']==1){
                $affectedRows = ShippingPackage::where('id', '>', 0)->update(array('is_default' => 0));
            }*/

            ShippingPackage::where('id', $id)->first()->update($validatedData);
            $package = ShippingPackage::where('id', $id)->first();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
