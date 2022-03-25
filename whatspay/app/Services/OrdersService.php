<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Store;
use App\Repositories\OrderHistoriesRepositoryInterface;
use App\Repositories\OrderPaymentsExtraDetailRepositoryInterface;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\OrdersRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrdersService
{
    /**
     * @var OrdersRepositoryInterface
     */
    protected $ordersRepository;
    protected $orderproductRepository;
    protected $orderpaymentsextradetailRepository;
    protected $orderhistoriesRepository;

    public function __construct(
        OrdersRepositoryInterface $ordersRepository,
        OrderProductRepositoryInterface $orderproductRepository,
        OrderHistoriesRepositoryInterface $orderhistoriesRepository,
        OrderPaymentsExtraDetailRepositoryInterface $orderpaymentsextradetailRepository
    ) {
        $this->ordersRepository = $ordersRepository;
        $this->orderproductRepository = $orderproductRepository;
        $this->orderhistoriesRepository = $orderhistoriesRepository;
        $this->orderpaymentsextradetailRepository = $orderpaymentsextradetailRepository;
    }

    public function store(Request $request)
    {
        try {//dd($request->all());
            DB::beginTransaction();
            $customer_id = Auth::id();
            $reference_no = $this->referenceNo($request->store_id);
            $order = $this->ordersRepository->create([
            'reference_no'=>$reference_no,
            'refrence_no_int'=>$request->refrence_no_int,
            'customer_id'=>$customer_id,
            'store_id'=>$request->store_id,
            'status'=>$request->status,
            'add_ons_amount'=>$request->add_ons_amount,
            'sub_total'=>$request->sub_total,
            'shipping_amount'=>$request->shipping_amount,
            'promo_code_amount'=>$request->promo_code_amount,
            'discount_amount'=>$request->discount_amount,
            'service_charges_amount'=>$request->service_charges_amount,
            'total_amount'=>$request->total_amount,
            'payment_channel'=>$request->payment_channel,
            'transaction_status'=>$request->transaction_status,
            'service_option'=>$request->service_option,
            'shipping_city'=>$request->shipping_city,
            'shipping_country'=>$request->shipping_country,
            'shipping_latitude'=>$request->shipping_latitude,
            'shipping_longitude'=>$request->shipping_longitude,
        ]);
            $order_id = $order->id;
            //            Order product
            foreach ($request->details as $detail) {
                $products = $this->orderproductRepository->create([
                'order_id'=>$order_id,
                'product_id'=>$detail['product_id'],
                'product_name'=>$detail['product_name'],
                'qty'=>$detail['qty'],
                'price'=>$detail['price'],
                'discount_amount'=>$detail['discount_amount'],
                'add_ons_detail'=>$detail['add_ons_detail'],
                'add_ons_amount'=>$detail['add_ons_amount'],
            ]);
            }
            $order_Extra = $this->orderpaymentsextradetailRepository->create([
            'order_id'=>$order_id,
            'customer_id'=>$customer_id,
            'store_id'=>$request->store_id,
            'description'=>$request->extra['description'] ?? '',
            'payment_detail'=>$request->extra['payment_detail'] ?? '',
        ]);
            //            Order History
            $order_history = $this->orderhistoriesRepository->create([
            'action'=>$request->histories['action'],
            'description'=>$request->histories['description'] ?? '',
            'extras'=>$request->histories['extras'] ?? '',
            'user_id'=>$customer_id,
            'order_id'=>$order_id,
        ]);

            $main = Orders::where('id', $order_id)
                      ->with('orderExtra', 'orderHistories', 'orderDetails')
                      ->first();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e->getMessage());
        }

        return $main;
    }

    public function destroy($id)
    {
        try {
            $delete = $this->ordersRepository->deleteById($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $delete;
    }

    public function show($id)
    {
        try {
            $details = $this->ordersRepository->findById($id, ['*'], ['orderExtra', 'orderHistories', 'orderDetails']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $details;
    }

    public function update(Request $request, $id)
    {
        try {//dd($request->all());
            DB::beginTransaction();
            $customer_id = Auth::id();
            $order = $this->ordersRepository->updateByColumn(
                [
                'id'=>$id,
                'store_id'=>$request->store_id,
                'customer_id'=>$customer_id,
                ],
                [
            'refrence_no_int'=>$request->refrence_no_int,
            'customer_id'=>$customer_id,
            'store_id'=>$request->store_id,
            'status'=>$request->status,
            'add_ons_amount'=>$request->add_ons_amount,
            'sub_total'=>$request->sub_total,
            'shipping_amount'=>$request->shipping_amount,
            'promo_code_amount'=>$request->promo_code_amount,
            'discount_amount'=>$request->discount_amount,
            'service_charges_amount'=>$request->service_charges_amount,
            'total_amount'=>$request->total_amount,
            'payment_channel'=>$request->payment_channel,
            'transaction_status'=>$request->transaction_status,
            'service_option'=>$request->service_option,
            'shipping_city'=>$request->shipping_city,
            'shipping_country'=>$request->shipping_country,
            'shipping_latitude'=>$request->shipping_latitude,
            'shipping_longitude'=>$request->shipping_longitude,
        ]
            );
            $order_id = $id;
            //            Order product
            foreach ($request->details as $detail) {
                if (!isset($detail['id'])) {
                    $detail['id'] = 0;
                }
                $products = $this->orderproductRepository->updateGetModel(
                    [
                    'id'=>$detail['id'],
                    'order_id'=>$id,
                    'product_id'=>$detail['product_id'],

                ],
                    [
                'order_id'=>$order_id,
                'product_id'=>$detail['product_id'],
                'product_name'=>$detail['product_name'],
                'qty'=>$detail['qty'],
                'price'=>$detail['price'],
                'discount_amount'=>$detail['discount_amount'],
                'add_ons_detail'=>$detail['add_ons_detail'],
                'add_ons_amount'=>$detail['add_ons_amount'],
            ]
                );
            }
            if (!isset($request->extra['id'])) {
                $request->extra['id'] = 0;
            }
            $order_Extra = $this->orderpaymentsextradetailRepository->updateGetModel(
                [
                'id'=>$request->extra['id'],
                'order_id'=>$id,
                'customer_id'=>$customer_id,
                ],
                [
            'order_id'=>$order_id,
            'customer_id'=>$customer_id,
            'store_id'=>$request->store_id,
            'description'=>$request->extra['description'] ?? '',
            'payment_detail'=>$request->extra['payment_detail'] ?? '',
        ]
            );

            $main = Orders::where('id', $order_id)
            ->with('orderExtra', 'orderHistories', 'orderDetails')
            ->first();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e->getMessage());
        }

        return $main;
    }

    public function referenceNo($store_id)
    {
        $data = Store::where('stores.id', $store_id)
            ->leftJoin('orders', 'stores.id', '=', 'orders.store_id')
            ->select(
                'stores.business_url As url',
                'stores.id As store_id',
                'orders.reference_no',
                'orders.id AS order_id',
            )
            ->orderBy('orders.id', 'desc')
            ->limit(1)
            ->first();
        $middle = $data->url;
        if (null != $data->reference_no) {
            $end = substr($data->reference_no, \strlen('WP' . $middle), );
            $end = $end + 1;

            return strtoupper('WP' . $middle . $end);
        }

        return strtoupper('WP' . $middle . '1');
    }

    public function view()
    {
        try {
            $orders = $this->ordersRepository->findAllByColumn(
                ['customer_id'=>Auth::id()],
                ['*'],
                ['orderExtra', 'orderHistories', 'orderDetails']
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $orders;
    }

    public function ordersStore(Request $request)
    {
        try {
            $orders = $this->ordersRepository->findAllByColumn(
                ['store_id'=>$request->store_id],
                ['*'],
                ['orderExtra', 'orderHistories', 'orderDetails']
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $orders;
    }

    public function statusUpdate(Request $request)
    {
        try {
            $order = $this->ordersRepository->findById(
                $request->order_id
            );

            switch (Auth::user()->user_type) {
                case 'company':
                case 'employee':
                if (1 == !$order->is_active) {
                    $order_status = $this->ordersRepository->update(
                        $request->order_id,
                        ['status' => $request->status]
                    );
                    foreach ($request->history as $history) {
                        $orderhistory = $this->orderhistoriesRepository->create(
                            [
                                'action'=>$history['action'],
                                'description'=>$history['description'],
                                'user_id '=>$history['user_id'],
                                'order_id'=>$history['order_id'],
                                'extras'=>$history['extras'],
                            ]
                        );
                    }
                }
                break;
                case 'visitor':
                     if (1 == !$order->is_confirmed) {
                         $order_status = $this->ordersRepository->update(
                             $request->order_id,
                             ['status'=>$request->status]
                         );

                         foreach ($request->history as $history) {
                             $orderhistory = $this->orderhistoriesRepository->create(
                                 [
                                 'action'=>$history['action'],
                                 'description'=>$history['description'],
                                 'user_id '=>$history['user_id'],
                                 'order_id'=>$history['order_id'],
                                 'extras'=>$history['extras'],
                             ]
                             );
                         }
                     }
                break;
                default:
                    throw new InvalidArgumentException('Something Went Wrong');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $order_status;
    }

    public function orderFliter(Request $request)
    {
        try {
            $from = $request->from ?? Carbon::today()->toDateString();
            $to = $request->to ?? Carbon::today()->toDateString();
            //dd($request->all());

            $orders = Orders::whereBetween('created_at', [$from . ' ' . '00.00.00', $to . ' ' . '23.59.59'])
                ->whereIn('status', $request->status)
                ->with('orderExtra', 'orderHistories', 'orderDetails')
                ->paginate(5);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $orders;
    }
}
