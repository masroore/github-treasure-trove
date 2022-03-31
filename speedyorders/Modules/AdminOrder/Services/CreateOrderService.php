<?php

namespace Modules\AdminOrder\Services;

use App\Models\Coupon;
use App\Models\CouponHistory;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\CustomerUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use App\Models\Product;
use App\Models\ProductOptionValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LaravelShipStation\Models\Address;
use LaravelShipStation\Models\Order as ProductOrder;
use LaravelShipStation\Models\OrderItem;
use LaravelShipStation\ShipStation;
use Log;
use Str;

class CreateOrderService
{
    public function handle(array $validatedData)
    {

        /*$shipStation = new ShipStation(env('SHIPSTATION_API_KEY'),env('SHIPSTATION_API_SECRET'), env('SHIPSTATION_API_URL'));

        $address = new Address();

        $address->name = $validatedData['shipping_first_name']." ".$validatedData['shipping_last_name'];
        $address->street1 = $validatedData['shipping_address_1'];
        $address->city = $validatedData['shipping_city'];
        $address->state = $validatedData['address_1'];
        $address->postalCode = $validatedData['shipping_postcode'];
        $address->country = "US";
        $address->phone = $validatedData['phone'];*/

        try {
            DB::beginTransaction();

            if (isset($validatedData['coupon_id'])) {
                $isCouponValid = $this->validateCoupon($validatedData['coupon_id'], $validatedData['product_id'], $validatedData['product_quantity']);
            }

            if (!isset($validatedData['customer_user_id'])) {
                $validatedData['customer_user_id'] = $this->createCustomer(
                    [
                        'first_name' => $validatedData['first_name'],
                        'last_name' => $validatedData['last_name'],
                        'telephone' => $validatedData['phone'],
                    ],
                    $validatedData['user_email']
                );
            }

            $orderuuid = (string) Str::uuid();
            $validatedData['uuid'] = $orderuuid;

            $order = Order::create($validatedData);

            $total_amt = 0; //total_amount to store in customer_transaction
            $products = Product::whereIn('id', $validatedData['product_id'])->get();

            $productArr = [];
            foreach ($validatedData['product_id'] as $pkey => $productId) {
                $product = $products->where('id', $productId)->first();

                $itemuuid = (string) Str::uuid();

                $orderProduct = OrderProduct::create([
                    'uuid' => $itemuuid,
                    'sku' => $product->sku,
                    'quantity' => $validatedData['product_quantity'][$pkey],
                    'price' => $product->base_price,
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // code to add the shipment at shipstation

                /* $productItem = new OrderItem();
                 $productItem->lineItemKey = $product->id;
                 $productItem->sku = $product->sku;
                 $productItem->name = $product->name;
                 $productItem->quantity = $validatedData['product_quantity'][$pkey];
                 $productItem->unitPrice  = $product->base_price;


                 $porder = new ProductOrder();

                 $porder->orderNumber = $itemuuid;
                 $porder->orderDate = now();
                 $porder->orderStatus = 'awaiting_shipment';
                 $porder->amountPaid = $product->base_price;
                 $porder->taxAmount = '0.00';
                 $porder->shippingAmount = '0.00';
                 $porder->internalNotes = $validatedData['comment'];
                 $porder->billTo = $address;
                 $porder->shipTo = $address;
                 $porder->items[] = $productItem;

                 $response = $shipStation->orders->create($porder);

                 if(isset($response->orderId) && $response->orderId!=''){
                     $orderProductData = OrderProduct::find($orderProduct->id);
                     $orderProductData->shipstation_order_id = $response->orderId;
                     $orderProductData->save();
                 }*/

                if (\count($product->options) > 0) {
                    if ($orderProduct && isset($validatedData['option'][$pkey])) {
                        foreach ($validatedData['option'][$pkey] as $type => $options) {
                            foreach ($options as $okey => $option) {
                                OrderProductOption::create([
                                    'order_id' => $order->id,
                                    'order_product_id' => $orderProduct->id,
                                    'product_option_id' => $okey,
                                    'product_option_value_id' => ('select' == $type) ? $option : null,
                                    'value' => ('select' == $type) ? null : $option,
                                    'type' => $type,
                                ]);
                                if ('select' == $type) {
                                    $productOptionValue = ProductOptionValue::find($option);
                                    $updatedPrice = $orderProduct->price;

                                    // Updating price based on option value E.G => RED color sells +$24
                                    if (isset($productOptionValue->price_prefix) && '' != $productOptionValue->price_prefix) {
                                        $updatedPrice += $productOptionValue->price;
                                    } else {
                                        if (isset($productOptionValue->price)) {
                                            $updatedPrice += $productOptionValue->price;
                                        }
                                    }

                                    $total_amt += $updatedPrice;
                                    $orderProduct->update([
                                            'price' => $updatedPrice,
                                            'quantity'=> $validatedData['product_quantity'][$pkey],
                                        ]);

                                    if (isset($productOptionValue->subtract_from_stock)) {
                                        $orderProduct->product->update([
                                            'quantity'=>$orderProduct->product->quantity - $validatedData['product_quantity'][$pkey],
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $total_amt += $product->base_price;
                }
            }

            // Log::info("Response Shipstation : ".json_encode(array("Res" => $response)));

            $customerTransaction = CustomerTransaction::create([
                'order_id' => $order->id,
                'customer_user_id' => $validatedData['customer_user_id'],
                'type' => 'debit',
                'amount' => $total_amt,
                'currency' => $validatedData['currency_code'],
                'status' => 'initialize',
                'remarks' =>  $validatedData['comment'],
            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Exception Message : ' . json_encode($e->getMessage()));
            dd($e);
            DB::rollback();

            return false;
        }
    }

    private function validateCoupon($coupon_id, $productIds, $productQuantities)
    {
        $isCouponValid = true;

        $coupon = Coupon::find($coupon_id);

        $totalUsed = CouponHistory::where('coupon_id', $coupon_id)->count();
        $totalUsedByThisUser = 0;
        $currentDate = Carbon::now();

        if (isset($validatedData['customer_id'])) {
            $totalUsedByThisUser = CouponHistory::where('coupon_id', $coupon_id)->where('customer_id', $validatedData['customer_id'])->count();
        }

        if ('0' == $coupon->status) {
            $isCouponValid = false;
            session()->flash('invalid_coupon', "Sorry coupon can't be added.It's inactive right now.");
        }

        if ($totalUsed >= $coupon->max_limit && $isCouponValid = true) {
            $isCouponValid = false;
            session()->flash('invalid_coupon', "Sorry coupon can't be added.Its max limit is reached.");
        }
        if ($currentDate < Carbon::parse($coupon->start_date) || $currentDate > Carbon::parse($coupon->end_date) && $isCouponValid = true) {
            $isCouponValid = false;
            session()->flash('invalid_coupon', "Sorry coupon can't be added at current date.");
        }
        if ($totalUsedByThisUser >= $coupon->limit_per_user && $isCouponValid = true) {
            $isCouponValid = false;
            session()->flash('invalid_coupon', "Sorry coupon can't be added.User has reached limit to use this coupon.");
        }

        $selectedPRoducts = Product::whereIn('id', $productIds)->get();

        $isQuantityAvailable = true;
        $selectedPRoducts->each(function ($item, $key) use ($productQuantities) {
            if ($item->quantity < $productQuantities[$key]) {
                session()->flash('insufficient_product_quantity', 'Sorry the requested quantity is not available of ' . $item->name . '.');
                $isQuantityAvailable = false;

                return false;
            }
        });

        if (!$isQuantityAvailable) {
            return false;
        }

        $totalOrderAmount = $selectedPRoducts->map(function ($item, $key) {
            return $item->price * $item->quantity;
        })->sum();

        if ($totalOrderAmount < $coupon->min_order_amount && $isCouponValid = true) {
            $isCouponValid = false;
        }

        if (false == $isCouponValid) {
            unset($coupon_id);
        }

        return true;
    }

    private function createCustomer(array $data, $email)
    {
        $customer = CustomerUser::where('email', $email)
            ->where('status', 1)
            ->first();

        if ($customer) {
            return $customer->id;
        }
        $data['email'] = $email;
        $data['password'] = Hash::make('customer');
        $data['status'] = '1';
        $newCustomer = CustomerUser::create($data);

        $customer = new Customer();
        $customer->customer_user_id = $newCustomer->id;
        $customer->first_name = $data['first_name'];
        $customer->last_name = $data['last_name'];
        $customer->telephone = $data['telephone'];
        $customer->status = 1;
        $customer->save();

        return $newCustomer->id;
    }
}
