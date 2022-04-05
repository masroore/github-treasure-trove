<?php

namespace Modules\AdminOrder\Services;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use App\Models\Product;
use App\Models\ProductOptionValue;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateOrderService
{
    public function handle(array $validatedData, $id)
    {
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

            $updateOrder = Order::where('id', $id)->first()->update($validatedData);
            if ($updateOrder) {
                $order = Order::where('id', $id)->with('orderedProducts', 'customerTransactions')->first();

                if ($order->orderedProducts) {
                    foreach ($order->orderedProducts as $p) {
                        $p->delete();
                        if ($p->orderProductOptions) {
                            foreach ($p->orderProductOptions as $p_option) {
                                $p_option->delete();
                            }
                        }
                    }
                }

                if ($order->customerTransactions) {
                    foreach ($order->customerTransactions as $t) {
                        $t->delete();
                    }
                }

                $total_amt = 0; //total_amount to store in customer_transaction
                $products = Product::whereIn('id', $validatedData['product_id'])->get();

                foreach ($validatedData['product_id'] as $pkey => $productId) {
                    $product = Product::with('options')->where('id', $productId)->first();

                    $orderProductData = [
                        'sku' => $product->sku,
                        'quantity' => $validatedData['product_quantity'][$pkey],
                        'price' => $product->base_price,
                        'order_id' => $id,
                        'product_id' => $product->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $orderProduct = OrderProduct::create($orderProductData);
                    if (\count($product->options) > 0) {
                        if (isset($orderProduct->id, $validatedData['option'][$pkey])) {
                            foreach ($validatedData['option'][$pkey] as $type => $options) {
                                foreach ($options as $okey => $option) {
                                    $orderProductOptionData = [
                                        'order_id' => $id,
                                        'order_product_id' => $orderProduct->id,
                                        'product_option_id' => $okey,
                                        'product_option_value_id' => ('select' == $type && $option) ? $option : null,
                                        'value' => ('select' == $type) ? null : $option,
                                        'type' => $type,
                                    ];

                                    OrderProductOption::create($orderProductOptionData);

                                    if ('select' == $type && $option) {
                                        $productOptionValue = ProductOptionValue::find($option);
                                        $updatedPrice = $orderProduct->price;

                                        //Updating price based on option value E.G => RED color sells +$24
                                        if ($productOptionValue->price_prefix) {
                                            $updatedPrice += $productOptionValue->price;
                                        } else {
                                            $updatedPrice += $productOptionValue->price;
                                        }

                                        $total_amt += $updatedPrice;
                                        $orderProduct->update([
                                            'price' => $updatedPrice,
                                            'quantity' => $validatedData['product_quantity'][$pkey],
                                        ]);

                                        if ($productOptionValue->subtract_from_stock) {
                                            $orderProduct->product->update([
                                                'quantity' => $orderProduct->product->quantity - $validatedData['product_quantity'][$pkey],
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

                $customerTransaction = CustomerTransaction::create([
                    'order_id' => $order->id,
                    'customer_user_id' => $validatedData['customer_user_id'],
                    'type' => 'debit',
                    'amount' => $total_amt,
                    'currency' => $validatedData['currency_code'],
                    'status' => 'initialize',
                    'remarks' => $validatedData['comment'],
                ]);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
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

        return $newCustomer->id;
    }
}
