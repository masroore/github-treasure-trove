<?php

namespace Modules\AdminCoupon\Services;

use App\Models\Coupon;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateCouponService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            $coupon = Coupon::create($validatedData);
            $coupon->products()->attach($validatedData['product_id']);
            $coupon->categories()->attach($validatedData['category_id']);
            $coupon->excludedProducts()->attach($validatedData['excluded_product_id']);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
