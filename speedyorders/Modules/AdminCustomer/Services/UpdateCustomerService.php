<?php

namespace Modules\AdminCustomer\Services;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerIpAddress;
use App\Models\CustomerTransaction;
use Illuminate\Support\Facades\DB;
use Log;

class UpdateCustomerService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find($id);

            $customer->first_name = $validatedData['first_name'];
            $customer->last_name = $validatedData['last_name'];
            $customer->email = $validatedData['email'];
            $customer->telephone = $validatedData['telephone'];
            $customer->safe = $validatedData['safe'];
            $customer->status = $validatedData['status'];
            $customer->newsletter = $validatedData['newsletter'];
            $customer->save();

            // Update address details

            if (isset($validatedData['address_id']) && '' != $validatedData['address_id']) {
                $customerAddress = CustomerAddress::find($validatedData['address_id']);

                $customerAddress->a_first_name = $validatedData['a_first_name'];
                $customerAddress->a_last_name = $validatedData['a_last_name'];
                $customerAddress->address_1 = $validatedData['address_1'];
                $customerAddress->address_2 = $validatedData['address_2'];
                $customerAddress->city = $validatedData['city'];
                $customerAddress->postcode = $validatedData['postcode'];
                $customerAddress->save();
            } else {
                if (isset($validatedData['a_first_name']) && '' != $validatedData['a_first_name']) {
                    $customerAddress = new CustomerAddress();
                    $customerAddress->a_first_name = $validatedData['a_first_name'];
                    $customerAddress->customer_user_id = $id;
                    $customerAddress->a_last_name = $validatedData['a_last_name'];
                    $customerAddress->address_1 = $validatedData['address_1'];
                    $customerAddress->address_2 = $validatedData['address_2'];
                    $customerAddress->city = $validatedData['city'];
                    //$customerAddress->postcode = $validatedData["postcode"];

                    $customerAddress->save();
                }
            }

            if (isset($validatedData['description']) && isset($validatedData['transaction_id'])) {
                if (isset($validatedData['transaction_id']) && '' != $validatedData['transaction_id']) {
                    $transaction_data = CustomerTransaction::find($validatedData['transaction_id']);
                } else {
                    $transaction_data = new CustomerTransaction();
                    $transaction_data->customer_user_id = $id;
                }

                if ('' != $validatedData['description'] || '' != $validatedData['amount']) {
                    $transaction_data->description = $validatedData['description'];
                    $transaction_data->amount = $validatedData['amount'];
                    $transaction_data->save();
                }
            }

            if (isset($validatedData['ip']) && isset($validatedData['total_accounts'])) {
                if (isset($validatedData['ip_id']) && '' != $validatedData['ip_id']) {
                    $ip_data = CustomerIpAddress::find($validatedData['ip_id']);
                } else {
                    $ip_data = new CustomerIpAddress();
                    $ip_data->customer_id = $id;
                }

                if ('' != $validatedData['ip'] || '' != $validatedData['total_accounts']) {
                    $ip_data->ip = $validatedData['ip'];
                    $ip_data->total_accounts = $validatedData['total_accounts'];
                    $ip_data->save();
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            DB::rollback();

            return false;
        }
    }
}
