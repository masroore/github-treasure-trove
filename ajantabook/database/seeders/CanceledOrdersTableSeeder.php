<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CanceledOrdersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('canceled_orders')->delete();

        DB::table('canceled_orders')->insert([
            0 => [
                'id' => 1,
                'order_id' => 1,
                'inv_id' => 1,
                'user_id' => 2,
                'comment' => 'Requested by User',
                'method_choosen' => 'bank',
                'amount' => 180.0,
                'is_refunded' => 'completed',
                'bank_id' => null,
                'transaction_id' => 'CODCAN6xjoCJYVc8',
                'txn_fee' => null,
                'read_at' => null,
                'created_at' => '2020-11-24 15:58:15',
                'updated_at' => '2020-11-24 15:58:15',
            ],
        ]);
    }
}
