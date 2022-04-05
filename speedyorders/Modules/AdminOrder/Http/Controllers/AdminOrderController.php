<?php

namespace Modules\AdminOrder\Http\Controllers;

use App\Models\Coupon;
use App\Models\CustomerUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductDeliveryTime;
use App\Models\ProductOption;
use App\Models\ShippingPackage;
use App\Models\ShippingZonePrice;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelShipStation\ShipStation;
use Log;
use Modules\AdminOrder\Http\Requests\CreateOrderHistoryRequest;
use Modules\AdminOrder\Http\Requests\CreateOrderRequest;
use Modules\AdminOrder\Http\Requests\UpdateOrderRequest;
use Modules\AdminOrder\Services\CreateOrderHistoryService;
use Modules\AdminOrder\Services\CreateOrderService;
use Modules\AdminOrder\Services\CreateShipstationOrderService;
use Modules\AdminOrder\Services\UpdateOrderService;
use PDF;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'orders',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $orders = Order::where('customer_user_id', 'LIKE', "%$keyword%")
                ->orWhere('invoice_number', 'LIKE', "%$keyword%")
                ->orWhere('invoice_prefix', 'LIKE', "%$keyword%")
                ->orWhere('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('address1', 'LIKE', "%$keyword%")
                ->orWhere('address2', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('postal_code', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('payment_first_name', 'LIKE', "%$keyword%")
                ->orWhere('payment_last_name', 'LIKE', "%$keyword%")
                ->orWhere('payment_company', 'LIKE', "%$keyword%")
                ->orWhere('payment_address1', 'LIKE', "%$keyword%")
                ->orWhere('payment_address2', 'LIKE', "%$keyword%")
                ->orWhere('payment_city', 'LIKE', "%$keyword%")
                ->orWhere('payment_postalcode', 'LIKE', "%$keyword%")
                ->orWhere('payment_country_name', 'LIKE', "%$keyword%")
                ->orWhere('payment_region', 'LIKE', "%$keyword%")
                ->orWhere('payment_method', 'LIKE', "%$keyword%")
                ->orWhere('payment_unique_code', 'LIKE', "%$keyword%")
                ->orWhere('shipping_first_name', 'LIKE', "%$keyword%")
                ->orWhere('shipping_last_name', 'LIKE', "%$keyword%")
                ->orWhere('shipping_company', 'LIKE', "%$keyword%")
                ->orWhere('shipping_address1', 'LIKE', "%$keyword%")
                ->orWhere('shipping_address2', 'LIKE', "%$keyword%")
                ->orWhere('shipping_city', 'LIKE', "%$keyword%")
                ->orWhere('shipping_postalcode', 'LIKE', "%$keyword%")
                ->orWhere('shipping_country_name', 'LIKE', "%$keyword%")
                ->orWhere('shipping_region', 'LIKE', "%$keyword%")
                ->orWhere('shipping_method', 'LIKE', "%$keyword%")
                ->orWhere('shipping_unique_code', 'LIKE', "%$keyword%")
                ->orWhere('shipping_tracking_code', 'LIKE', "%$keyword%")
                ->orWhere('comment', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('commisison', 'LIKE', "%$keyword%")
                ->orWhere('currency_code', 'LIKE', "%$keyword%")
                ->orWhere('currency_value', 'LIKE', "%$keyword%")
                ->orWhere('ip', 'LIKE', "%$keyword%")
                ->orderByDesc('id')
                ->latest()->paginate($perPage);
        } else {
            $orders = Order::latest()->orderByDesc('id')->paginate($perPage);
        }

        return view('adminorder::index', compact('orders'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'orders',
        ];
        $customers = CustomerUser::select('id', 'email')->get();
        $products = Product::select('id', 'name', 'base_price', 'sku')->get();
        $coupons = Coupon::select('id', 'code')->get();

        return view('adminorder::create', compact('customers', 'products', 'coupons'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateOrderRequest $request, CreateOrderService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Order created successfully.');
        } else {
            session()->flash('error_message', 'Order could not be created.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = [
            'menu' => 'orders',
        ];

        $order = Order::with('orderedProducts', 'orderedProducts.orderProductOptions')->findOrFail($id);

        return view('adminorder::show', compact('order'), $data);
    }

    /**
     * Process the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\Process
     */
    public function process($id)
    {
        $data = [
            'menu' => 'orders',
            'order_id' => $id,
        ];

        $order = Order::with('orderedProducts', 'orderedProducts.orderProductOptions')->findOrFail($id);

        //$packages = ShippingPackage::select('id','package_name')->get();

        //$productDeliveryTimeGroup = $productDeliveryTimePackage = '';
        /* $deliveryTimes = [];
         if(isset($product->delivery_time) && !empty($product->delivery_time)){
             foreach($product->delivery_time as $timeData){
                 $productDeliveryTimePackage = $timeData->shipping_packages_id;
                 $productDeliveryTimeGroup = $timeData->shipping_zone_groups_id;

                 array_push($deliveryTimes, $timeData->shipping_delivery_times_id);
             }
         }*/

//        print_r($order->orderedProducts);die;

        return view('adminorder::process', compact('order'), $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'orders',
        ];

        $order = Order::where('id', $id)->with('orderedProducts', 'orderedProducts.orderProductOptions')->first();
        $customers = CustomerUser::select('id', 'email')->get();
        $products = Product::select('id', 'name', 'base_price', 'sku')->get();
        $coupons = Coupon::get();

        return view('adminorder::edit', compact('order', 'customers', 'products', 'coupons'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateOrderRequest $request, $id, UpdateOrderService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Order updated successfully.');
        } else {
            session()->flash('error_message', 'Order could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Order::destroy($id);

        return redirect()->route('admin.orders.index')->with('flash_message', 'Order deleted!');
    }

    public function updateOrderStatus($id)
    {
        try {
            $order = Order::find($id);
            if ('1' == $order->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Order::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Order updated successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Order could not be updated.');
        }

        return redirect()->route('admin.orders.index');
    }

    public function optionValue(Request $request)
    {
        if (!$request->productId) {
            return;
        }

        $productOptions = ProductOption::where('product_id', $request->productId)
            ->with('product', 'optionValues', 'option')->get();

        $responseHtml = '';
        if (!empty($productOptions)) {
            foreach ($productOptions as $po) {
                Log::info('PO:' . json_encode($po));
                if (isset($po->option) && !empty($po->option)) {
                    switch ($po->option->type) {
                        case 'input':
                            $returnHTML = view('adminorder::htmlelement.input', [
                                'option' => $po->option,
                                'productId' => $request->productId,
                                'productOption' => $po,
                            ])->render();
                            $responseHtml .= $returnHTML;

                        break;
                        case 'text':
                            $returnHTML = view('adminorder::htmlelement.input', [
                                'option' => $po->option,
                                'productId' => $request->productId,
                                'productOption' => $po,
                            ])->render();
                            $responseHtml .= $returnHTML;

                        break;
                        case 'select':
                            $returnHTML = view('adminorder::htmlelement.select', [
                                'option' => $po->option,
                                'productId' => $request->productId,
                                'productOption' => $po,
                            ])->render();
                            $responseHtml .= $returnHTML;

                        break;
                    }
                }
            }
        }

        return response()->json(['success' => true, 'html' => $responseHtml]);
    }

    /**
     * All below packages will show based on the postal code used in the order and selected zone prices in the products edit.
     *
     * @param  Request productId
     *
     * @return json return all available packages
     */
    public function packageValue(Request $request)
    {
        if (!$request->productId) {
            return;
        }

        $shipping_postcode = (isset($request->shipping_postcode)) ? $request->shipping_postcode : '';
        $productId = $request->productId;
        $orderId = $request->orderId;

        $groups = ProductDeliveryTime::where('products_id', $productId)->get();

        $packages = $product_packages_array = [];
        if (!empty($groups)) {
            $group_final_array = $groups->toArray();

            $groups_array = array_unique(array_column($group_final_array, 'shipping_zone_groups_id'));

            $product_packages_array = array_unique(array_column($group_final_array, 'shipping_packages_id'));

            if ($shipping_postcode && '' != $shipping_postcode) {
                $packages = ShippingZonePrice::leftjoin('shipping_packages', 'shipping_packages.id', '=', 'shipping_zone_prices.shipping_packages_id')
                    ->leftjoin('shipping_delivery_times', 'shipping_delivery_times.id', '=', 'shipping_zone_prices.shipping_delivery_times_id');

                if ($groups_array && !empty($groups_array) && null != $groups_array[0]) {
                    $packages = $packages->whereIn('shipping_zone_groups_id', $groups_array)->groupby('shipping_packages_id');
                }

                if ($shipping_postcode && '' != $shipping_postcode && empty($groups_array)) {
                    $packages = $packages->where('zip_code', $shipping_postcode)
                        ->groupby('shipping_packages_id');
                }

                $packages = $packages->get(['shipping_packages_id as id', 'shipping_packages.package_name', 'shipping_delivery_times.name']);
            }
        }

        $responseHtml = '';
        $responseHtmlDeliveryTime = '';

        $selectname = 'single_product_package[]';

        $returnHTML = view('adminorder::htmlelement.package', [
            'option' => 'Package',
            'productPackage' => $packages,
            'productId' => $productId,
            'selectname' => $selectname,
            'product_packages_array' => $product_packages_array,
        ])->render();

        $selectnamedeliverytime = 'single_product_deliverytime[]';

        $orderedProduct = OrderProduct::where('product_id', $productId)->first();
        $deliveryData = $orderedProduct->product->delivery_time;

        $orderProductData = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->first();

        $responseHtmlDeliveryTime = view('adminorder::htmlelement.orderdeliverytime', [
            'option' => 'DeliveryTime',
            'productDeliveryTimes' => $deliveryData,
            'productId' => $productId,
            'selectnamedeliverytime' => $selectnamedeliverytime,
            'selectedId' => (isset($orderProductData->shipping_delivery_times_id) && '' != $orderProductData->shipping_delivery_times_id) ? $orderProductData->shipping_delivery_times_id : '',
        ])->render();

        return response()->json(['success' => true, 'html' => $returnHTML, 'deliveryHtml' => $responseHtmlDeliveryTime]);
    }

    public function showOrderInvoices($id)
    {
        $order = Order::where('id', $id)->with('orderedProducts', 'orderedProducts.orderProductOptions')->first();
        $pdf = PDF::loadView('adminorder::report', compact('order'));

        return $pdf->stream('doc.pdf');
    }

    public function showOrderShippingInvoices($id)
    {
        $order = Order::where('id', $id)->with('orderedProducts', 'orderedProducts.orderProductOptions')->first();
        $pdf = PDF::loadView('adminorder::shipping-report', compact('order'));

        return $pdf->stream('shippingdoc.pdf');
    }

    public function adminOrderHistoryStore(CreateOrderHistoryRequest $request, CreateOrderHistoryService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Order history created successfully.');
        } else {
            session()->flash('error_message', 'Order history could not be created.');

            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }

    public function getOrderData(): void
    {
        $shipStation = new ShipStation('28243d7551d441a3ac6acddcb937f255', 'b8adcebd9271434781d84f5ebca8e705', 'https://ssapi.shipstation.com');

        //  $order = $shipStation->orders->getOrderId('113-0885678-6154618'); // returns integer

        $order = $shipStation->orders->get([], $endpoint = '751103607'); // returns \stdClass

        print_r($order);
        exit;
    }

    public function getStep2Html(Request $request)
    {
        $orderId = $request->orderId;
        $productsIds = json_decode($request->productsIds);
        $productNames = json_decode($request->productNames);
        $listPackages = $request->listPackages;
        $listDeliveryTimes = $request->listDeliveryTimes;

        $singles = $request->listSingle;

        $singalarr = $comboarr = [];

        $indexsingle = $indexcombo = 0;
        foreach ($singles as $key => $value) {
            if (1 == $value) {
                $singalarr[$indexsingle]['id'] = $productsIds[$key];
                $singalarr[$indexsingle]['name'] = $productNames[$key];
                $singalarr[$indexsingle]['product_price'] = $this->getProductPrice($orderId, $productsIds[$key]);
                $singalarr[$indexsingle]['package'] = $this->getPackageName($listPackages[$key]);
                $singalarr[$indexsingle]['deliverytime'] = $this->getDeliveryData($listDeliveryTimes[$key]);
                $singalarr[$indexsingle]['deliverytimeprice'] = $this->getDeliveryData($listDeliveryTimes[$key], $productsIds[$key], $listPackages[$key]);
                ++$indexsingle;
            }

            if (0 == $value) {
                $comboarr[$indexcombo]['id'] = $productsIds[$key];
                $comboarr[$indexcombo]['name'] = $productNames[$key];
                $comboarr[$indexcombo]['product_price'] = $this->getProductPrice($orderId, $productsIds[$key]);
                ++$indexcombo;
            }
        }

        $returnHTML = view('adminorder::htmlelement.step2', [
            'singalarr' => $singalarr,
            'comboarr' => $comboarr,
            //'productUnitPrices' => $productUnitPrices,
            //'productQuantities' => $productQuantities,
            //'productTotals' => $productTotals,
            //'listPackages' => $listPackages,
        ])->render();

        return response()->json(['success' => true, 'html' => $returnHTML]);
    }

    public function getPackageName($packageId)
    {
        $package = DB::table('shipping_packages')->select('package_name')->where('id', $packageId)->first();

        return (isset($package->package_name)) ? ucfirst($package->package_name) : 'NA';
    }

    public function getProductPrice($orderId, $productId)
    {
        $price_data = DB::table('order_products')
            ->where('order_id', $orderId)
            ->where('product_id', $productId)
            ->select(['price', 'quantity'])
            ->first();

        return ($price_data->price * $price_data->quantity) ? ($price_data->price * $price_data->quantity) : 0;
    }

    public function getDeliveryData($deliveryTimeId, $productId = '', $packageId = '')
    {
        $price = '';
        if ($productId && '' != $productId) {
            $shipping_zone_groups_id = DB::table('product_deliverytime')->where('products_id', $productId)->pluck('shipping_zone_groups_id')->first();
            if (isset($shipping_zone_groups_id) && '' != $shipping_zone_groups_id) {
                $price = DB::table('shipping_zone_prices')
                    ->where('shipping_zone_groups_id', $shipping_zone_groups_id)
                    ->where('shipping_delivery_times_id', $deliveryTimeId)
                    ->where('shipping_packages_id', $packageId)
                    ->pluck('price')
                    ->first();
            }

            return $price;
        }
        $time = DB::table('shipping_delivery_times')->select('name')->where('id', $deliveryTimeId)->first();

        return (isset($time->name)) ? ucfirst($time->name) : 'NA';
    }

    /**
     * added the order details related to send on shipstation and send the details there in pending state.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function processOrder(Request $request, CreateShipstationOrderService $shipstationService)
    {
        if ($shipstationService->handle($request)) {
            $message = 'Order successfully sent on shipstation.';
        } else {
            $message = 'Order could not be sent on shipstation, Please refresh the page and try again.';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * All below delivery times will show based on the postal code used in the order and selected package at order package.
     *
     * @param  Request productId
     *
     * @return json return all available packages
     */
    public function packageDeliveryTimes(Request $request)
    {
        if (!$request->productId || !$request->packageId) {
            return;
        }

        $productId = $request->productId;
        $packageId = $request->packageId;
        $groups = $request->groups;

        $deliveryTimes = ShippingZonePrice::where('shipping_packages_id', $packageId)
            ->leftjoin('shipping_delivery_times', 'shipping_delivery_times.id', '=', 'shipping_zone_prices.shipping_delivery_times_id')
            ->select(['shipping_zone_prices.id', 'shipping_packages_id as package_id', 'shipping_delivery_times.name', 'price']);

        if (isset($request->shipping_postcode) && '' != $request->shipping_postcode) {
            $deliveryTimes = $deliveryTimes->where('shipping_zone_prices.zip_code', $request->shipping_postcode);
        }

        if (isset($request->groups) && '' != $request->groups) {
            $groups_array = json_decode($groups);
            $deliveryTimes = $deliveryTimes->where('shipping_zone_prices.zip_code', $groups_array);
        }

        $deliveryTimes = $deliveryTimes->get();

        $responseHtml = '';

        $selectname = 'product_delivery_time_' . $productId . '[]';

        $returnHTML = view('adminorder::htmlelement.deliverytime', [
            'option' => 'Package',
            'deliveryTimes' => $deliveryTimes,
            'productId' => $request->productId,
            'selectname' => $selectname,
        ])->render();

        $responseHtml .= $returnHTML;

        return response()->json(['success' => true, 'html' => $responseHtml]);
    }
}
