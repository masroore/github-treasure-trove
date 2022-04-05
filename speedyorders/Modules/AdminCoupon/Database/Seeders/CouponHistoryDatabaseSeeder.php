<?php

namespace Modules\AdminCoupon\Database\Seeders;

use App\Models\CouponHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CouponHistoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        for ($i = 0; $i < 20; ++$i) {
            CouponHistory::create([
                'coupon_code' => mt_rand(1, 200),
                'order_id' => mt_rand(1, 200),
                'customer_id' => mt_rand(1, 200),
                'order_amount' => mt_rand(10000, 50000),
                'status' => mt_rand(10000, 50000),
            ]);
        }

        // $this->call("OthersTableSeeder");
    }
}
