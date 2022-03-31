<?php

namespace Modules\AdminCoupon\Database\Seeders;

use App\Models\CouponHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CouponHistoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 0; $i < 20; $i++) {
            CouponHistory::create([
                'coupon_code' => rand(1, 200),
                'order_id' => rand(1, 200),
                'customer_id' => rand(1, 200),
                'order_amount' =>  rand(10000, 50000),
                'status' =>  rand(10000, 50000),
            ]);
        }

        // $this->call("OthersTableSeeder");
    }
}
