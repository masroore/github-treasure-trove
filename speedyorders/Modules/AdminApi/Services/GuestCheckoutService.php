<?php

namespace Modules\AdminApi\Services;

use App\Events\SendOrderMail;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerTransaction;
use App\Models\CustomerUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDF;
use Stripe\Charge;
use Stripe\Stripe;

class GuestCheckoutService
{
    public function handle($request)
    {
        try {
            DB::beginTransaction();

            $orderData = $request->only(
                'first_name',
                'last_name',
                'address_1',
                'address_2',
                'email',
                'postcode',
                'phone',
                'shipping_first_name',
                'shipping_last_name',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_state',
                'shipping_city',
                'shipping_postcode',
                'shipping_phone',
                'shipping_email'
            );
            $orderData['customer_user_id'] = $this->createCustomerUser($request);
            $orderData['invoice_number'] = Str::random(5);
            $orderData['shipping_country_name'] = $request->shipping_country;

            $orderData['payment_first_name'] = $request->first_name;
            $orderData['payment_last_name'] = $request->last_name;
            $orderData['payment_address_1'] = $request->address_1;
            $orderData['payment_address_2'] = $request->address_2;
            $orderData['payment_city'] = $request->city;
            $orderData['payment_state'] = $request->state;
            $orderData['payment_postcode'] = $request->postcode;
            $orderData['payment_country_name'] = $request->country;

            $order = Order::create($orderData);

            $total_amt = 0;

            foreach ($request->cart as $cart) {
                $product = Product::where('status', '1')->where('id', $cart['product_id'])->with('options')->first();
                $priceTax = $this->calculatePriceTax($product, $cart, $request->shipping_state);

                $total_amt += $priceTax['amtWithTax'];
                $orderProduct = OrderProduct::create([

                                'quantity' => $cart['quantity'],
                                'price' => $priceTax['price'],
                                'tax'   => $priceTax['tax'],
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                if (isset($cart['options']) && \count($cart['options']) > 0) {
                    foreach ($cart['options'] as $option_id => $option_value) {
                        $product_option = ProductOption::where('id', $option_id)->first();

                        $type = $product_option->option->type;

                        OrderProductOption::create([
                                            'order_id' => $order->id,
                                            'order_product_id' => $orderProduct->id,
                                            'product_option_id' => $option_id,
                                            'product_option_value_id' => ('select' == $type) ? $option_value : null,
                                            'value' => ('select' == $type) ? null : $option_value,
                                            'type' => $type,
                                        ]);
                    }
                }
            }

            $customerTransaction = CustomerTransaction::create([
                            'order_id' => $order->id,
                            'customer_user_id' => $orderData['customer_user_id'],
                            'type' => 'debit',
                            'amount' => number_format($total_amt, 2),
                            'currency' => 'usd',
                            'status' => 'initialize',
                            'remarks' =>  'new order placed',
                        ]);

            Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51IpSxXA0PwlsNEoFo3XkzbOpXA4o4CZr811SFtAyc6wUxPnvmCodVoSR09TfDityMt02biQ2gkWvIoTwOz6a9DYk00DyjBCmh3'));
            try {
                $charge = Charge::create([
                               'amount' => number_format($total_amt, 2) * 100,
                               'currency' => 'usd',
                               'source' => $request->stripeToken,
                               'description' => 'Making test payment.',
                               'receipt_email' => $request->email,
                               'metadata' => [
                                   'order_id' => $order->id,
                               ],
                           ]);

                if ('succeeded' == $charge->status) {
                    $customerTransaction->status = 'completed';
                } else {
                    $customerTransaction->status = 'pending';
                }
                $customerTransaction->save();
            } catch (\Exception $e) {
                DB::rollback();
                Log::info('checkout : ' . $e->getMessage());

                return response()->json([
                                'status'=>'stripeError',
                                'msg'   => $e->getMessage(),
                            ]);
            }

            DB::commit();

            try {
                $pdf = PDF::loadView('emails.ordermail', compact('order'));

                event(new SendOrderMail($pdf, $request->email));
            } catch (\Exception $e) {
                Log::info('order-mail : ' . $e->getMessage());
            }

            return response()->json([
                            'status'=>200,
                            'msg'   => 'Your order has been placed successfully !',
                            'order_id'  => 'speedy-order-' . $order->invoice_number,
                        ]);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            Log::info('checkout : ' . $e->getMessage());

            return response()->json([
                    'status'=>500,
                    'msg'   => 'something went wrong',
                ]);
        }
    }

    private function calculatePriceTax($product, $cart, $state)
    {
        $productPrice = $product->base_price;
        $taxAmt = 0;
        $totalPrice = 0;
        $amtWithTax = 0;
        //  if product has variant
        if (\count($product->options) > 0) {
            foreach ($cart['options'] as $option_id => $option_value) {
                $product_option = ProductOption::where('id', $option_id)->first();
                $type = $product_option->option->type;
                if ('select' == $type) {
                    $productOptionValue = ProductOptionValue::find($option_value);

                    // Updating price based on option value E.G => RED color sells +$24
                    if ($productOptionValue->price_prefix) {
                        $productPrice += $productOptionValue->price;
                    } else {
                        $productPrice -= $productOptionValue->price;
                    }

                    // updating variant stock
                    if ($productOptionValue->subtract_from_stock) {
                        $productOptionValue->update([
                            'quantity'=>$productOptionValue->quantity - $cart['quantity'],
                        ]);
                    }
                }
            }
        } else {
            // updating product without variant stock
            if ($product->subtract_from_stock) {
                $product->update([
                    'quantity'=>$product->quantity - $cart['quantity'],
                ]);
            }
        }

        $totalPrice = $productPrice * $cart['quantity'];

        if ('Illinois' == $state) {
            $taxAmt = (7.5 / 100) * $totalPrice;
        }

        return [
                'price' => $productPrice,
                'tax'   => $taxAmt,
            'amtWithTax' => $totalPrice + $taxAmt,
        ];
    }

    private function createCustomerUser($request)
    {
        $customerUser = CustomerUser::create([

            'email'=>$request->email,
            'password'=>Hash::make('customer'),
            'status' => 1,
            ]);

        Customer::create([
                'customer_user_id'  => $customerUser->id,
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'phone'             => $request->phone,
            ]);

        // primary address
        CustomerAddress::create([
                'customer_user_id'=> $customerUser->id,
                'country'   => $request->country,
                'state'     => $request->state,
                'city'      => $request->city,
                'postcode'  => $request->postcode,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
            ]);

        // secondary address
        CustomerAddress::create([
                'customer_user_id'=> $customerUser->id,
                'country'   => $request->shipping_country,
                'state'     => $request->shipping_state,
                'city'      => $request->shipping_city,
                'postcode'  => $request->shipping_postcode,
                'address_1' => $request->shipping_address_1,
                'address_2' => $request->shipping_address_2,
            ]);

        return $customerUser->id;
    }
}
