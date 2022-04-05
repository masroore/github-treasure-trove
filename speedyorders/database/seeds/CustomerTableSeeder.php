<?php

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerUser;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('customer_users')->truncate();

        $customerUser = CustomerUser::create([
            'email' => 'customer@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => \Carbon\Carbon::now(),
            'status' => 1,
        ]);

        $customer = Customer::create([
            'customer_user_id' => $customerUser->id,
            'first_name' => 'anish',
            'last_name' => 'shrestha',
            'date_of_birth' => now(),
            'phone' => '9806044433',
        ]);

        CustomerAddress::create([
            'customer_id' => $customer->id,
            'address_1' => 'kathmandu',
            'address_2' => 'basundhara',
            'city' => 'kathmandu',
            'postcode' => '7864',
            'country' => '123',
            'region_id' => '3',
        ]);
    }
}
