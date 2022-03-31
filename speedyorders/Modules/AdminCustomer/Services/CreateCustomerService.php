<?php

namespace Modules\AdminCustomer\Services;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Log;

class CreateCustomerService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            $validatedData['password'] = Hash::make(rand());

            $customer = Customer::create($validatedData);
            if ($validatedData['a_first_name']) {
                $customerAddress = new CustomerAddress();
                $customerAddress->a_first_name = $validatedData['a_first_name'];
                $customerAddress->customer_user_id = $customer->id;
                $customerAddress->a_last_name = $validatedData['a_last_name'];
                $customerAddress->address_1 = $validatedData['address_1'];
                $customerAddress->address_2 = $validatedData['address_2'];
                $customerAddress->city = $validatedData['city'];
                //$customerAddress->postcode = $validatedData["postcode"];
                $customerAddress->save();
            }

            if (isset($validatedData['description'])) {
                $transaction_data = new CustomerTransaction();
                $transaction_data->customer_user_id = $customer->id;

                if ('' != $validatedData['description'] || '' != $validatedData['amount']) {
                    $transaction_data->description = $validatedData['description'];
                    $transaction_data->amount = $validatedData['amount'];
                    $transaction_data->save();
                }
            }

            if (isset($validatedData['ip'])) {
                $ip_data = new CustomerIpAddress();
                $ip_data->customer_id = $customer->id;

                if ('' != $validatedData['ip'] || '' != $validatedData['total_accounts']) {
                    $ip_data->ip = $validatedData['ip'];
                    $ip_data->total_accounts = $validatedData['total_accounts'];
                    $ip_data->save();
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            //dd($e);
            Log::info('Error:' . $e->getMessage());
            DB::rollback();

            return false;
        }
    }
}
