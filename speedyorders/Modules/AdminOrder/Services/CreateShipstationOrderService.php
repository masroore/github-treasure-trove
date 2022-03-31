<?php

namespace Modules\AdminOrder\Services;

use App\Models\CustomerTransaction;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShippingPackage;
use App\Models\ShippingZonePrice;
use DB;
use LaravelShipStation\Models\Address;
use LaravelShipStation\Models\Dimensions;
use LaravelShipStation\Models\Order as ProductOrder;
use LaravelShipStation\Models\OrderItem;
use LaravelShipStation\Models\Weight;
use LaravelShipStation\ShipStation;
use Log;
use Str;

class CreateShipstationOrderService
{
    public function handle($validatedData)
    {

        //echo "<pre>";
        // print_r($validatedData->all());die;

        $productQuantities = json_decode($validatedData['productQuantities']);
        $productTotals = json_decode($validatedData['productTotals']);

        $orderId = $validatedData->orderId;
        $orderData = Order::find($orderId)->toArray();

        try {
            DB::beginTransaction();

            $orderuuid = $orderData['uuid'];

            $total_amt = 0;
            $shippingPrice = 0;
            $products = json_decode($validatedData['productsIds']);

            // separate the sinngle and combo products
            $singleProducts = $productPackageArr = $comboProducts = $deliveryTimesArr = [];
            $singlesindexes = $validatedData['listSingle'];
            $singleDeliveryTimes = $validatedData['listDeliveryTimes'];
            $listPackages = $validatedData['listPackages'];

            foreach ($products as $key => $productId) {
                if (isset($singlesindexes[$key]) && 1 == $singlesindexes[$key]) {
                    $singleProducts[] = $productId;
                } else {
                    $comboProducts[] = $productId;
                }

                $productPackageArr[$productId] = $listPackages[$key];
                $deliveryTimesArr[$productId] = $singleDeliveryTimes[$key];
            }

            //echo "<pre>";
            //print_r($productPackageArr);
            //print_r($comboProducts);

            //die;

            //dd($singleProducts);
            //dd($comboProducts);

            if (!empty($singleProducts)) {
                $this->handle_single($orderData, $orderId, $productPackageArr, $deliveryTimesArr, $singleProducts, $singleDeliveryTimes);
            }

            if (!empty($comboProducts)) {
                $this->handle_combo($validatedData, $orderData, $orderId, $productPackageArr, $deliveryTimesArr, $comboProducts, $singleDeliveryTimes);
            }

            $orderData = Order::find($orderId);
            $orderData->status = 3;
            $orderData->save();

            $customerTransaction = CustomerTransaction::create([
                'order_id' => $orderData['id'],
                'customer_user_id' => $orderData['customer_user_id'],
                'type' => 'debit',
                'amount' => $total_amt,
                'currency' => $orderData['currency_code'],
                'status' => 'initialize',
                'remarks' =>  $orderData['comment'],
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

    public function handle_single($orderData, $orderId, $productPackageArr, $deliveryTimesArr, $singleProducts, $singleDeliveryTimes)
    {
        $orderuuid = (string) Str::uuid();

        //dd("single");
        // create orders for single products
        $shipStation = new ShipStation(env('SHIPSTATION_API_KEY'), env('SHIPSTATION_API_SECRET'), env('SHIPSTATION_API_URL'));
        $address = new Address();

        $address->name = $orderData['shipping_first_name'] . ' ' . $orderData['shipping_last_name'];
        $address->street1 = $orderData['shipping_address_1'];
        $address->city = $orderData['shipping_city'];
        $address->state = $orderData['address_1'];
        $address->postalCode = $orderData['shipping_postcode'];
        $address->country = 'US';
        $address->phone = $orderData['phone'];

        $indexv = 0;
        foreach ($singleProducts as $productId) {
            Log::info('indexv : ' . $indexv);

            //Get product quantities
            $quantity = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->pluck('quantity')->first();

            //Package details
            $shipping_packages_id = $productPackageArr[$productId];
            $shipping_delivery_times_id = $deliveryTimesArr[$productId];

            //echo $shipping_delivery_times_id."->".$shipping_packages_id;die;

            $shippingPrice = ShippingZonePrice::where('shipping_delivery_times_id', $shipping_delivery_times_id)
                ->where('shipping_packages_id', $shipping_packages_id)
                ->pluck('price')
                ->first();

            $package_length = $package_width = $package_height = $package_weight = 0;
            $package_size_unit = '';
            $package_weight_unit = 'oz';

            if ($shipping_packages_id && '' != $shipping_packages_id) {
                $packgae_data = ShippingPackage::find($shipping_packages_id);

                $package_length = $packgae_data->package_length;
                $package_width = $packgae_data->package_width;
                $package_height = $packgae_data->package_height;

                $package_size_unit = $packgae_data->package_size_unit;

                $package_weight = $packgae_data->package_weight;
                $package_weight_unit = $packgae_data->package_weight_unit;
            }

            if ('cm' == $package_size_unit) {
                $package_length = $package_length * env('CM_TO_INCH');
                $package_width = $package_width * env('CM_TO_INCH');
                $package_height = $package_height * env('CM_TO_INCH');
            }

            $dimensions = new Dimensions();
            $dimensions->length = $package_length;
            $dimensions->width = $package_width;
            $dimensions->height = $package_height;
            $dimensions->units = 'inchs';

            if ('kg' == $package_weight_unit) {
                $package_weight = $package_weight * env('KG_TO_OZ');
            } elseif ('lb' == $package_weight_unit) {
                $package_weight = $package_weight * env('LB_TO_OZ');
            }

            $weight = new Weight();
            $weight->value = $package_weight;
            $weight->units = 'oz';

            $product = Product::find($productId);

            $orderPriceQtydataSingle = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->select('quantity', 'price')->first();

            $productItem2 = new OrderItem();
            $productItem2->lineItemKey = $product->uuid;
            $productItem2->sku = $product->sku;
            $productItem2->name = $product->name;
            $productItem2->quantity = $orderPriceQtydataSingle->quantity;
            $productItem2->unitPrice = $orderPriceQtydataSingle->price;

            $porder = new ProductOrder();

            $pdatawithqty = (float) ($orderPriceQtydataSingle->price) * (int) ($orderPriceQtydataSingle->quantity);
            $amount_paid = $pdatawithqty + $shippingPrice;

            $porder->orderNumber = $orderuuid;
            $porder->orderKey = $orderuuid;
            $porder->orderDate = $orderData['created_at'];
            $porder->orderStatus = 'awaiting_shipment';
            $porder->amountPaid = $amount_paid;
            $porder->taxAmount = '0.00';
            $porder->shippingAmount = $shippingPrice;
            $porder->billTo = $address;
            $porder->shipTo = $address;
            $porder->dimensions = $dimensions;
            $porder->weight = $weight;
            $porder->items[] = $productItem2;

            //echo "<pre>";

            //echo $total_amt;
            //dd($porder);

            Log::info('Order Data : ' . json_encode($porder));

            $response_single = $shipStation->orders->create($porder);

            //dd($response_single);

            if (isset($response_single->orderId) && '' != $response_single->orderId) {
                $orderProductData = OrderProduct::where('order_id', $orderData['id'])->where('product_id', $product->id)->first();
                $orderProductData->shipstation_order_id = $response_single->orderId;
                $orderProductData->shipping_price = $shippingPrice;
                $orderProductData->shipping_delivery_times_id = $singleDeliveryTimes[$indexv];
                $orderProductData->orderuuid = $orderuuid;
                $orderProductData->save();
            }

            $indexv++;
        }
    }

    public function handle_combo($validatedData, $orderData, $orderId, $productPackageArr, $deliveryTimesArr, $comboProducts, $singleDeliveryTimes)
    {

    //dd("combo");

        $orderuuid = (string) Str::uuid();

        $shipStation2 = new ShipStation(env('SHIPSTATION_API_KEY'), env('SHIPSTATION_API_SECRET'), env('SHIPSTATION_API_URL'));

        $address2 = new Address();

        $address2->name = $orderData['shipping_first_name'] . ' ' . $orderData['shipping_last_name'];
        $address2->street1 = $orderData['shipping_address_1'];
        $address2->street2 = $orderData['shipping_address_2'];
        $address2->city = $orderData['shipping_city'];
        $address2->state = $orderData['shipping_state'];
        $address2->postalCode = $orderData['shipping_postcode'];
        $address2->country = 'US';
        $address2->phone = $orderData['phone'];

        // Combo product parameters
        $package_length = (isset($validatedData['package_length'])) ? $validatedData['package_length'] : 0;
        $package_width = (isset($validatedData['package_width'])) ? $validatedData['package_width'] : 0;
        $package_height = (isset($validatedData['package_height'])) ? $validatedData['package_height'] : 0;
        $package_size_unit = (isset($validatedData['package_size_unit']) && 'cm' == $validatedData['package_size_unit']) ? 'cm' : 'inchs';

        if ('cm' == $package_size_unit) {
            $package_length = $package_length * env('CM_TO_INCH');
            $package_width = $package_width * env('CM_TO_INCH');
            $package_height = $package_height * env('CM_TO_INCH');
        }

        $dimensions = new Dimensions();
        $dimensions->length = $package_length;
        $dimensions->width = $package_width;
        $dimensions->height = $package_height;
        $dimensions->units = 'inchs';

        $package_weight = (isset($validatedData['package_weight'])) ? $validatedData['package_weight'] : 0;
        $package_weight_unit = (isset($validatedData['package_weight_unit'])) ? $validatedData['package_weight_unit'] : '';

        if ('kg' == $package_weight_unit) {
            $package_weight = $package_weight * env('KG_TO_OZ');
        } elseif ('lb' == $package_weight_unit) {
            $package_weight = $package_weight * env('LB_TO_OZ');
        }

        $weight = new Weight();
        $weight->value = $package_weight;
        $weight->units = 'oz';

        // create orders for combo products
        $porder2 = new ProductOrder();
        $porder2->orderNumber = $orderuuid;
        $porder2->orderKey = $orderuuid;
        $porder2->orderDate = $orderData['created_at'];
        $porder2->orderStatus = 'awaiting_shipment';
        $porder2->billTo = $address2;
        $porder2->shipTo = $address2;
        $porder2->dimensions = $dimensions;
        $porder2->weight = $weight;

        $total_amt_combo = 0;

        foreach ($comboProducts as $productId) {

                //get product quantities
            $orderPriceQtydata = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->select('quantity', 'price')->first();

            $product = Product::find($productId);

            $productItem = new OrderItem();
            $productItem->lineItemKey = $product->uuid;
            $productItem->sku = $product->sku;
            $productItem->name = $product->name;
            $productItem->quantity = $orderPriceQtydata->quantity;
            $productItem->unitPrice = $orderPriceQtydata->price;

            $total_amt_combo += $orderPriceQtydata->price * $orderPriceQtydata->quantity;

            $porder2->taxAmount += '0.00';
            $porder2->shippingAmount += '0.00';
            $porder2->items[] = $productItem;
        }

        $porder2->amountPaid = $total_amt_combo;

        Log::info('P Order 2:' . json_encode($porder2));

        $response_combo = $shipStation2->orders->create($porder2);

        if (isset($response_combo->orderId) && '' != $response_combo->orderId) {
            foreach ($comboProducts as $productId) {
                $orderProductData = OrderProduct::where('order_id', $orderData['id'])->where('product_id', $productId)->first();
                $orderProductData->shipstation_order_id = $response_combo->orderId;
                $orderProductData->orderuuid = $orderuuid;
                $orderProductData->save();
            }
        }
    }

    public function saveProductProcessData()
    {
        $productQuantities = json_decode($validatedData['productQuantities']);
        $productTotals = json_decode($validatedData['productTotals']);

        $orderId = $validatedData->orderId;
        $orderData = Order::find($orderId)->toArray();

        try {
            DB::beginTransaction();

            $orderuuid = $orderData['uuid'];

            $total_amt = 0;
            $products = json_decode($validatedData['productsIds']);

            // separate the sinngle and combo products
            $singleProducts = [];
            $comboProducts = [];
            $singlesindexes = $validatedData['listSingle'];

            foreach ($products as $key => $productId) {
                //if(isset($singlesindexes[$key]) && $singlesindexes[$key]==1){
                $singleProducts[] = $productId;
                //} else {
                  //  $comboProducts[] = $productId;
                //}
            }

            $indexv = 1;
            foreach ($singleProducts as $productId) {
                Log::info('indexv : ' . $indexv);

                //get product quantities
                $quantity = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->pluck('quantity')->first();

                $total_amt += $product->base_price;

                Log::info('Order Data : ' . json_encode($porder));

                $response_single = $shipStation->orders->create($porder);

                if (isset($response_single->orderId) && '' != $response_single->orderId) {
                    $orderProductData = OrderProduct::where('order_id', $orderData['id'])->where('product_id', $product->id)->first();
                    $orderProductData->shipstation_order_id = $response_single->orderId;
                    $orderProductData->save();
                }

                $indexv++;
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Exception Message : ' . json_encode($e->getMessage()));
            dd($e);
            DB::rollback();

            return false;
        }
    }
}
