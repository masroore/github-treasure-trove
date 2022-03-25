<?php

use Illuminate\Database\Seeder;

class WalletsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

     //   \DB::table('wallets')->delete();

        \DB::table('wallets')->insert([
            0 => [
                'id' => 1,
                'holder_type' => 'App\\User',
                'holder_id' => 2,
                'name' => 'Default Wallet',
                'slug' => 'default',
                'description' => null,
                'balance' => '1050',
                'decimal_places' => 2,
            ],
            1 => [
                'id' => 2,
                'holder_type' => 'App\\User',
                'holder_id' => 3,
                'name' => 'Default Wallet',
                'slug' => 'default',
                'description' => null,
                'balance' => '21412',
                'decimal_places' => 2,
            ],
        ]);
    }
}
