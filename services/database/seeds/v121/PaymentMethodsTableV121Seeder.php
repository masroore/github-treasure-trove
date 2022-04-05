<?php
/*
 * File name: PaymentMethodsTableV121Seeder.php
 * Last modified: 2021.08.10 at 18:03:35
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class PaymentMethodsTableV121Seeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'id' => 11,
                'name' => 'Wallet',
                'description' => 'Click to pay with Wallet',
                'route' => '/Wallet',
                'order' => 8,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-08-08 22:38:42',
                'updated_at' => '2021-08-08 22:38:42',
            ],
        ]);
    }
}
