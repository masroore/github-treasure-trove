<?php

namespace Modules\AdminCoupon\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class UpdateCouponService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            Coupon::where('id', $id)->first()->update($validatedData);
            $coupon = Coupon::where('id', $id)->first();
            if (isset($validatedData['product_id'])) {
                $coupon->products()->sync($validatedData['product_id']);
            } else {
                $coupon->products()->sync([]);
            }
            if (isset($validatedData['excluded_product_id'])) {
                $coupon->products()->sync($validatedData['excluded_product_id']);
            } else {
                $coupon->excludedProducts()->sync([]);
            }
            if (isset($validatedData['category_id'])) {
                $coupon->categories()->sync($validatedData['category_id']);
            } else {
                $coupon->excludedProducts()->sync([]);
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
