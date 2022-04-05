<?php

namespace Modules\Report\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Repositories\ProductRepository;
use Modules\Report\Repositories\PurchaseReportRepositoryInterface;

class HistoryController extends Controller
{
    protected $productRepository;

    protected $wareHouseRepository;

    protected $showRoomRepository;

    protected $contactRepositories;

    protected $purchaseReportRepository;

    protected $userRepository;

    public function __construct(
        ProductRepository $productRepository,
        WareHouseRepositoryInterface $wareHouseRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        ContactRepositoriesInterface $contactRepositories,
        PurchaseReportRepositoryInterface $purchaseReportRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->contactRepositories = $contactRepositories;
        $this->purchaseReportRepository = $purchaseReportRepository;
        $this->userRepository = $userRepository;
    }

    public function purchaseHistory()
    {
        try {
            $data = [
                'products' => $this->productRepository->all(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'suppliers' => $this->contactRepositories->supplier(),
                'users' => $this->userRepository->user(),
            ];

            return view('report::history.purchase_history')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function searchPurchase(Request $request)
    {
        $request->validate([
            'product' => 'required_without_all:house_id,supplier_id,status,from_date,to_date,user_id',
            'house_id' => 'required_without_all:product,supplier_id,status,from_date,to_date,user_id',
            'status' => 'required_without_all:product,supplier_id,house_id,from_date,to_date,user_id',
            'from_date' => 'required_without_all:product,supplier_id,house_id,status,to_date,user_id',
            'to_date' => 'required_without_all:product,supplier_id,house_id,status,from_date,user_id',
            'supplier_id' => 'required_without_all:product,house_id,status,from_date,to_date,user_id',
            'user_id' => 'required_without_all:product,supplier_id,house_id,status,from_date,to_date',
        ]);

        try {
            $orders = $this->purchaseReportRepository->purchaseHistory($request->product, $request->house_id, $request->supplier_id, $request->status, $request->from_date, $request->to_date, $request->user_id);
            $data = [
                'items' => $orders,
                'sku' => $request->product,
                'house' => $request->house_id,
                'supplier_id' => $request->supplier_id,
                'status' => $request->status,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'user_id' => $request->user_id,
                'products' => $this->productRepository->all(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'suppliers' => $this->contactRepositories->supplier(),
                'users' => $this->userRepository->user(),
            ];

            return view('report::history.purchase_history')->with($data);
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function saleHistory()
    {
        try {
            $data = [
                'products' => $this->productRepository->all(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'customers' => $this->contactRepositories->customer(),
                'users' => $this->userRepository->user(),
            ];

            return view('report::history.sale_history')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function searchSale(Request $request)
    {
        $request->validate([
            'product' => 'required_without_all:house_id,customer_id,status,from_date,to_date,user_id',
            'house_id' => 'required_without_all:product,customer_id,status,from_date,to_date,user_id',
            'status' => 'required_without_all:product,customer_id,house_id,from_date,to_date,user_id',
            'from_date' => 'required_without_all:product,customer_id,house_id,status,to_date,user_id',
            'to_date' => 'required_without_all:product,customer_id,house_id,status,from_date,user_id',
            'customer_id' => 'required_without_all:product,house_id,status,from_date,to_date,user_id',
            'user_id' => 'required_without_all:product,house_id,status,from_date,to_date,customer_id',
        ]);

        try {
            $orders = $this->purchaseReportRepository->saleHistory($request->product, $request->house_id, $request->customer_id, $request->status, $request->from_date, $request->to_date, $request->user_id);
            $data = [
                'items' => $orders,
                'sku' => $request->product,
                'house' => $request->house_id,
                'customer_id' => $request->customer_id,
                'status' => $request->status,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'user_id' => $request->user_id,
                'products' => $this->productRepository->all(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'customers' => $this->contactRepositories->customer(),
                'users' => $this->userRepository->user(),
            ];

            return view('report::history.sale_history')->with($data);
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }
}
