<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class OrderActivityLogsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('order_activity_logs')->delete();

        DB::table('order_activity_logs')->insert([
            0 => [
                'id' => 1,
                'order_id' => '1',
                'inv_id' => 2,
                'user_id' => 2,
                'variant_id' => 2,
                'log' => 'Cancelled',
                'created_at' => '2020-11-24 15:06:35',
                'updated_at' => '2020-11-24 15:06:35',
            ],
            1 => [
                'id' => 2,
                'order_id' => '4',
                'inv_id' => 10,
                'user_id' => 1,
                'variant_id' => 4,
                'log' => 'Processed',
                'created_at' => '2020-11-24 15:25:03',
                'updated_at' => '2020-11-24 15:25:03',
            ],
            2 => [
                'id' => 3,
                'order_id' => '4',
                'inv_id' => 11,
                'user_id' => 1,
                'variant_id' => 1,
                'log' => 'Shipped',
                'created_at' => '2020-11-24 15:25:05',
                'updated_at' => '2020-11-24 15:25:05',
            ],
            3 => [
                'id' => 4,
                'order_id' => '4',
                'inv_id' => 9,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Delivered',
                'created_at' => '2020-11-24 15:25:15',
                'updated_at' => '2020-11-24 15:25:15',
            ],
            4 => [
                'id' => 5,
                'order_id' => '3',
                'inv_id' => 6,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Processed',
                'created_at' => '2020-11-24 15:25:26',
                'updated_at' => '2020-11-24 15:25:26',
            ],
            5 => [
                'id' => 6,
                'order_id' => '3',
                'inv_id' => 7,
                'user_id' => 1,
                'variant_id' => 4,
                'log' => 'Shipped',
                'created_at' => '2020-11-24 15:25:28',
                'updated_at' => '2020-11-24 15:25:28',
            ],
            6 => [
                'id' => 7,
                'order_id' => '2',
                'inv_id' => 3,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Processed',
                'created_at' => '2020-11-24 15:25:39',
                'updated_at' => '2020-11-24 15:25:39',
            ],
            7 => [
                'id' => 8,
                'order_id' => '2',
                'inv_id' => 4,
                'user_id' => 1,
                'variant_id' => 4,
                'log' => 'Shipped',
                'created_at' => '2020-11-24 15:25:40',
                'updated_at' => '2020-11-24 15:25:40',
            ],
            8 => [
                'id' => 9,
                'order_id' => '2',
                'inv_id' => 3,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Shipped',
                'created_at' => '2020-11-24 15:25:41',
                'updated_at' => '2020-11-24 15:25:41',
            ],
            9 => [
                'id' => 10,
                'order_id' => '2',
                'inv_id' => 5,
                'user_id' => 1,
                'variant_id' => 1,
                'log' => 'Delivered',
                'created_at' => '2020-11-24 15:25:43',
                'updated_at' => '2020-11-24 15:25:43',
            ],
            10 => [
                'id' => 11,
                'order_id' => '1',
                'inv_id' => 1,
                'user_id' => 1,
                'variant_id' => 1,
                'log' => 'Cancelled',
                'created_at' => '2020-11-24 15:28:45',
                'updated_at' => '2020-11-24 15:28:45',
            ],
            11 => [
                'id' => 12,
                'order_id' => '1',
                'inv_id' => 2,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Cancelled',
                'created_at' => '2020-11-24 15:53:48',
                'updated_at' => '2020-11-24 15:53:48',
            ],
            12 => [
                'id' => 13,
                'order_id' => '1',
                'inv_id' => 1,
                'user_id' => 1,
                'variant_id' => 1,
                'log' => 'Cancelled',
                'created_at' => '2020-11-24 15:58:15',
                'updated_at' => '2020-11-24 15:58:15',
            ],
            13 => [
                'id' => 14,
                'order_id' => '1',
                'inv_id' => 2,
                'user_id' => 1,
                'variant_id' => 2,
                'log' => 'Shipped',
                'created_at' => '2020-11-24 15:58:48',
                'updated_at' => '2020-11-24 15:58:48',
            ],
        ]);
    }
}
