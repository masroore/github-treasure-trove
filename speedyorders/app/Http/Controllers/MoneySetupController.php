<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use App\Models\ProductDeliveryTime;
use App\Models\ShippingZonePrice;
use App\Models\TempCart;
use App\Models\TempCustomerDetail;
use App\Models\TempCustomerTransaction;
use App\Models\TempProductOptionValue;
use App\Utils\Option;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Log;
use Session;
use Str;
use Stripe;

class MoneySetupController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
    {

        //Option::get('stripe_enable_status');

        $publisher_key = Option::get('stripe_key');
        $stripe_secret = Option::get('stripe_secret');

        $stripe_payment_mode = Option::get('stripe_payment_mode');
        if ('SANDBOX' == $stripe_payment_mode) {
            $publisher_key = Option::get('stripe_key');
            $stripe_secret = Option::get('stripe_secret');
        } elseif ('LIVE' == $stripe_payment_mode) {
            $publisher_key = Option::get('live_stripe_key');
            $stripe_secret = Option::get('live_stripe_secret');
        }

        $php_session_id = session()->getId();

        $total_price_arr = DB::select('SELECT `temp_cart`.quantity, `temp_cart`.unit_price, shipping_zone_price FROM `temp_cart` where `temp_cart`.php_session_id = "' . $php_session_id . '" ');

        $grandtotal = 0;

        foreach ($total_price_arr as $pricearr) {
            $product_total = 0;
            $qty = $pricearr->quantity;
            $unit_price = $pricearr->unit_price;
            $shippingcharge = $pricearr->shipping_zone_price;

            $product_total = (float) $unit_price * (int) $qty;

            if ($shippingcharge) {
                $product_total = (float) $product_total + (float) $shippingcharge;
            }

            $grandtotal += $product_total;
        }

        $final_price = $grandtotal;

        $inputs = $request->all();

        if (!empty($inputs) && isset($request->first_name) && '' != $request->first_name) {
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $address_1 = $request->address_1;
            $address_2 = $request->address_2;
            $email = $request->email;
            $phone = $request->phone;
            $shipping_country_name = $request->shipping_country_name;
            $region = $request->region;
            $city = $request->city;
            $postcode = $request->postcode;
            $comment = (isset($request->comment)) ? $request->comment : '';

            $tempcustomer = TempCustomerDetail::where('php_session_id', $php_session_id)->first();
            if (empty($tempcustomer)) {
                $tempcustomer = new TempCustomerDetail();
                $tempcustomer->php_session_id = $php_session_id;
                $tempcustomer->created_at = now();
            }

            $tempcustomer->first_name = $first_name;
            $tempcustomer->last_name = $last_name;
            $tempcustomer->address_1 = $address_1;
            $tempcustomer->address_2 = $address_2;
            $tempcustomer->email = $email;
            $tempcustomer->postcode = $postcode;
            $tempcustomer->phone = $phone;

            $tempcustomer->payment_first_name = $first_name;
            $tempcustomer->payment_last_name = $last_name;
            $tempcustomer->payment_company = '';
            $tempcustomer->payment_address_1 = $address_1;
            $tempcustomer->payment_address_2 = $address_2;
            $tempcustomer->payment_city = $city;
            $tempcustomer->payment_region = $region;
            $tempcustomer->payment_postcode = $postcode;
            $tempcustomer->payment_country_name = $shipping_country_name;

            $tempcustomer->payment_method = 'stripe';
            $tempcustomer->payment_unique_code = '';

            $tempcustomer->shipping_first_name = $first_name;
            $tempcustomer->shipping_last_name = $last_name;
            $tempcustomer->shipping_company = '';
            $tempcustomer->shipping_address_1 = $address_1;
            $tempcustomer->shipping_address_2 = $address_2;
            $tempcustomer->shipping_city = $city;
            $tempcustomer->shipping_region = $region;
            $tempcustomer->shipping_postcode = $postcode;
            $tempcustomer->shipping_country_name = $shipping_country_name;

            $tempcustomer->shipping_method = 'shipstation';
            $tempcustomer->shipping_unique_code = '';
            $tempcustomer->shipping_tracking_code = '';

            $tempcustomer->comment = $comment;

            $tempcustomer->status = $comment;
            $tempcustomer->currency_code = 'USD';
            $tempcustomer->currency_value = '';

            $tempcustomer->save();
        }

        $activePage = 'Payment';

        return view('cart.payment', compact('activePage', 'final_price', 'publisher_key'));
    }

    public function stripePost(Request $request)
    {
        try {
            DB::beginTransaction();

            $php_session_id = session()->getId();
            $tempcustomer = TempCustomerDetail::where('php_session_id', $php_session_id)->first();

            // Now need to create user if not exists
            $customer_user_id = CustomerUser::where('email', $tempcustomer->email)->pluck('id')->first();

            $total_price_arr = DB::select('SELECT `temp_cart`.quantity, `temp_cart`.unit_price, shipping_zone_price FROM `temp_cart` where `temp_cart`.php_session_id = "' . $php_session_id . '" ');

            $grandtotal = 0;

            foreach ($total_price_arr as $pricearr) {
                $product_total = 0;
                $qty = $pricearr->quantity;
                $unit_price = $pricearr->unit_price;
                $shippingcharge = $pricearr->shipping_zone_price;
                $product_total = (float) $unit_price * (int) $qty;

                if ($shippingcharge) {
                    $product_total = (float) $product_total + (float) $shippingcharge;
                }

                $grandtotal += $product_total;
            }

            $final_price = $grandtotal;

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $chargeArry = [
                'amount' => $final_price * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Speedy Order Payment for the user ',
                'receipt_email' => $tempcustomer->email,

            ];

            $response = \Stripe\Charge::create($chargeArry);

            $paymentStatus = (isset($response->status)) ? $response->status : '';

            if ($paymentStatus && 'succeeded' == $paymentStatus) {
                Log::info('Payment Success');

                $temptransaction = new TempCustomerTransaction();
                $temptransaction->description = '';
                $temptransaction->php_session_id = $php_session_id;
                $temptransaction->status = $paymentStatus;
                $temptransaction->amount = $final_price;
                $temptransaction->created_at = now();
                $temptransaction->save();

                Log::info('Check customer user id : ' . $customer_user_id);

                if (!$customer_user_id) {
                    Log::info('Found customer user id : ' . $customer_user_id);

                    $password = Hash::make(mt_rand());
                    $customeruser = new CustomerUser();
                    $customeruser->email = $tempcustomer->email;
                    $customeruser->password = $password;
                    $customeruser->status = 1;
                    $customeruser->created_at = now();
                    $customeruser->save();

                    $customer_user_id = $customeruser->id;

                    Log::info('Found customer user id : ' . $customer_user_id);

                    // create new customer

                    $customer = new Customer();
                    $customer->first_name = $tempcustomer->first_name;
                    $customer->last_name = $tempcustomer->last_name;
                    $customer->email = $tempcustomer->email;
                    $customer->telephone = $tempcustomer->phone;
                    $customer->status = 1;
                    $customer->customer_user_id = $customer_user_id;
                    $customer->phone = $tempcustomer->phone;
                    $customer->save();
                }

                // create entry in orders table and order products related tables

                Log::info('get customer details : ' . json_encode($tempcustomer));

                $orderData = new Order();
                $orderuuid = (string) Str::uuid();
                $orderData->uuid = $orderuuid;
                $orderData->customer_user_id = $customer_user_id;

                $orderData->first_name = $tempcustomer->first_name;
                $orderData->last_name = $tempcustomer->last_name;
                $orderData->address_1 = $tempcustomer->address_1;
                $orderData->address_2 = $tempcustomer->address_2;
                $orderData->email = $tempcustomer->email;
                $orderData->postcode = $tempcustomer->postcode;
                $orderData->phone = $tempcustomer->phone;

                $orderData->payment_first_name = $tempcustomer->first_name;
                $orderData->payment_last_name = $tempcustomer->last_name;
                $orderData->payment_company = '';
                $orderData->payment_address_1 = $tempcustomer->address_1;
                $orderData->payment_address_2 = $tempcustomer->address_2;
                $orderData->payment_city = $tempcustomer->payment_city;
                $orderData->payment_region = $tempcustomer->payment_region;
                $orderData->payment_state = $tempcustomer->payment_region;
                $orderData->payment_postcode = $tempcustomer->postcode;
                $orderData->payment_country_name = $tempcustomer->shipping_country_name;

                $orderData->payment_method = 'stripe';
                $orderData->payment_unique_code = '';

                $orderData->shipping_first_name = $tempcustomer->first_name;
                $orderData->shipping_last_name = $tempcustomer->last_name;
                $orderData->shipping_company = '';
                $orderData->shipping_address_1 = $tempcustomer->address_1;
                $orderData->shipping_address_2 = $tempcustomer->address_2;
                $orderData->shipping_city = $tempcustomer->shipping_city;
                $orderData->shipping_region = $tempcustomer->shipping_region;
                $orderData->shipping_state = $tempcustomer->shipping_region;
                $orderData->shipping_postcode = $tempcustomer->postcode;
                $orderData->shipping_country_name = $tempcustomer->shipping_country_name;

                $orderData->shipping_method = 'shipstation';
                $orderData->shipping_unique_code = '';
                $orderData->shipping_tracking_code = '';

                $orderData->comment = $tempcustomer->comment;

                $orderData->status = 2; // for processing
                $orderData->currency_code = 'USD';
                $orderData->currency_value = 50;

                $orderData->save();

                // now add order products
                $tempCartItems = TempCart::where('php_session_id', $php_session_id)->get();
                foreach ($tempCartItems as $tempitem) {
                    $itemuuid = (string) Str::uuid();

                    $productDeliveryTimeId = '';
                    if (isset($tempitem->product_delivery_time_id) && '' != $tempitem->product_delivery_time_id) {
                        $productDeliveryTimeId = ProductDeliveryTime::where('id', $tempitem->product_delivery_time_id)->pluck('shipping_delivery_times_id')->first();
                    }

                    $orderProduct = OrderProduct::create([
                        'uuid' => $itemuuid,
                        'sku' => $tempitem->sku,
                        'quantity' => $tempitem->quantity,
                        'price' => $tempitem->unit_price,
                        'order_id' => $orderData->id,
                        'product_id' => $tempitem->product_id,
                        'shipping_delivery_times_id' => (isset($productDeliveryTimeId) && '' != $productDeliveryTimeId) ? $productDeliveryTimeId : null,
                        'shipping_price' => $tempitem->shipping_zone_price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // check if options found for the cart product
                    $tempCartItemOptions = TempProductOptionValue::where('php_session_id', $php_session_id)->where('product_id', $tempitem->product_id)->get();
                    if (!empty($tempCartItemOptions)) {
                        foreach ($tempCartItemOptions as $optionItem) {
                            $orderProductOption = OrderProductOption::create([
                                'order_id' => $orderData->id,
                                'order_product_id' => $orderProduct->id,
                                'product_option_id' => $optionItem->option_id,
                                'value' => $optionItem->option_value,
                                'type' => 'input',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }

                // Now delete all temprary data
                DB::delete('delete from temp_cart where php_session_id = ?', [$php_session_id]);
                DB::delete('delete from temp_customer_details where php_session_id = ?', [$php_session_id]);
                DB::delete('delete from temp_product_option_value where php_session_id = ?', [$php_session_id]);
                DB::delete('delete from temp_customer_transaction where php_session_id = ?', [$php_session_id]);

                Log::info('Stripe Response : ' . json_encode($response));
                Session::flash('success', 'Payment Successful!');

                DB::commit();

                return redirect('/stripeformsuccess/' . $orderuuid);
            }

            $temptransaction = new TempCustomerTransaction();
            $temptransaction->description = '';
            $temptransaction->php_session_id = $php_session_id;
            $temptransaction->status = $paymentStatus;
            $temptransaction->amount = $final_price;
            $temptransaction->created_at = now();
            $temptransaction->save();

            Log::info('Stripe Response : ' . json_encode($response));
            Session::flash('error', 'Something went wrong, please try again');

            DB::commit();

            return redirect('/stripeform');
        } catch (Exception $e) {
            Log::info('Exception : ' . $e->getMessage());
            DB::rollback();

            return false;
        }
    }

    public function stripeSuccess($orderid)
    {
        $activePage = 'Receipt';

        $sucess = 'You have successfully completed order and order id : ' . $orderid;

        return view('cart.receipt', compact('sucess', 'homepage_categories', 'activePage'));
    }

    // public function deliverytime_price(Request $request) {
    // 	$productId = $request->product_id;
    // 	$product_delivery_time_id = $request->delivery_time_id;

    // 	if ($productId == '' || $product_delivery_time_id == '') {
    // 		return 0;
    // 	}

    // 	$deliveryData = ProductDeliveryTime::find($product_delivery_time_id);

    // 	$shipping_zone_groups_id = $deliveryData->shipping_zone_groups_id;
    // 	$shipping_packages_id = $deliveryData->shipping_packages_id;
    // 	$shipping_delivery_times_id = $deliveryData->shipping_delivery_times_id;

    // 	$priceDetails = ShippingZonePrice::where('shipping_zone_groups_id', $shipping_zone_groups_id)->where('shipping_packages_id', $shipping_packages_id)->where('shipping_delivery_times_id', $shipping_delivery_times_id)->first();

    // 	$shipping_zone_price = $priceDetails["price"];
    // 	$shipping_zone_price_id = $priceDetails["id"];

    // 	$php_session_id = session()->getId();
    // 	$tempcartdetails = TempCart::where('php_session_id', $php_session_id)->where('product_id', $productId);
    // 	$tempdata = array("shipping_zone_price" => $shipping_zone_price,
    // 	"product_delivery_time_id" => $product_delivery_time_id);
    // 	$tempcartdetails->update($tempdata);

    // 	return $shipping_zone_price;
    // }

    // public function checkProductAvailability(Request $request) {
    // 	$productId = $request->product_id;
    // 	$pincode = $request->pincode;

    // 	if ($productId == '' || $pincode == '') {
    // 		return 0;
    // 	}

    // 	$deliveryData = ProductDeliveryTime::leftjoin('shipping_zone_prices', 'shipping_zone_prices.shipping_zone_groups_id', '=', 'product_deliverytime.shipping_zone_groups_id')
    // 					->where('product_deliverytime.products_id',$productId)
    // 					->where('shipping_zone_prices.zip_code',$pincode)
    // 					->pluck("shipping_zone_prices.id")
    // 					->first();

    // 	if($deliveryData){
    // 		return json_encode(array("msg" => "Available"));;
    // 	}	else {
    // 		return json_encode(array("msg" => "Not Available"));;
    // 	}

    // }
}
