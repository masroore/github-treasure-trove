<?php

namespace Modules\Report\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Report\Repositories\SalesReportRepositoryInterface;

class SalesReportController extends Controller
{
    protected $salesReportRepository;

    protected $showRoomRepository;

    protected $contactRepository;

    protected $userRepository;

    public function __construct(
        SalesReportRepositoryInterface $salesReportRepository,
        UserRepositoryInterface $userRepository,
        ContactRepositoriesInterface $contactRepository,
        ShowRoomRepositoryInterface $showRoomRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->salesReportRepository = $salesReportRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->contactRepository = $contactRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $showrooms = $this->showRoomRepository->all();
            $customers = $this->contactRepository->customer();
            $staffs = $this->userRepository->all(['user']);

            if ($request->dateTo != null && $request->dateFrom == null) {
                Toastr::warning(__('report.You need to set date-from when you select date-to.'));

                return view('report::sales_report.index', compact('sales', 'showrooms', 'customers', 'productSkus', 'staffs'));
            }

            if ($request->dateTo == null && $request->dateFrom != null) {
                Toastr::warning(__('report.You need to set date-to when you select date-from.'));

                return view('report::sales_report.index', compact('sales', 'showrooms', 'customers', 'productSkus', 'staffs'));
            }

            $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
            $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;
            $showRoom_id = ($request->showRoom_id != null) ? $request->showRoom_id : null;
            $retailer_id = ($request->retailer_id != null) ? $request->retailer_id : null;
            $customer_id = ($request->customer_id != null) ? $request->customer_id : null;
            $type = ($request->type != null) ? $request->type : null;
            $user_id = ($request->user_id != null) ? $request->user_id : null;
            $sales = $this->salesReportRepository->search($dateFrom, $dateTo, $showRoom_id, $retailer_id, $customer_id, $user_id, $type);

            return view('report::sales_report.index', compact('sales', 'showrooms', 'customers', 'staffs', 'dateFrom', 'type', 'dateTo', 'showRoom_id', 'retailer_id', 'customer_id', 'user_id'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function product_sales_index(Request $request, ProductRepositoryInterface $productRepository)
    {
        $showrooms = $this->showRoomRepository->all();
        $customers = $this->contactRepository->customer();
        $productSkus = $productRepository->allProduct();
        $staffs = $this->userRepository->all(['user']);

        $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
        $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;

        if ($request->dateTo != null && $request->dateFrom == null) {
            Toastr::warning(__('report.You need to set date-from when you select date-to.'));

            return view('report::sales_report.index', compact('showrooms', 'customers', 'productSkus', 'staffs', 'dateFrom', 'dateTo'));
        }
        if ($request->dateTo == null && $request->dateFrom != null) {
            Toastr::warning(__('report.You need to set date-to when you select date-from.'));

            return view('report::sales_report.index', compact('showrooms', 'customers', 'productSkus', 'staffs', 'dateFrom', 'dateTo'));
        }
        $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
        $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;
        $productSku_id = ($request->productSku_id != null) ? $request->productSku_id : null;
        $sales = $this->salesReportRepository->searchProduct($dateFrom, $dateTo, $productSku_id);

        return view('report::sales_report.product_sales_report', compact('sales', 'showrooms', 'customers', 'productSkus', 'dateFrom', 'dateTo', 'staffs', 'productSku_id'));
    }

    public function sales_return_report(Request $request)
    {
        $showrooms = $this->showRoomRepository->all();
        $customers = $this->contactRepository->customer();
        $staffs = $this->userRepository->all(['user']);

        if ($request->dateTo != null && $request->dateFrom == null) {
            Toastr::warning(__('report.You need to set date-from when you select date-to.'));

            return view('report::sales_report.index', compact('sales', 'showrooms', 'customers', 'productSkus', 'staffs'));
        }
        if ($request->dateTo == null && $request->dateFrom != null) {
            Toastr::warning(__('report.You need to set date-to when you select date-from.'));

            return view('report::sales_report.index', compact('sales', 'showrooms', 'customers', 'productSkus', 'staffs'));
        }
        $showRoom_id = ($request->showRoom_id != null) ? $request->showRoom_id : null;
        $retailer_id = ($request->retailer_id != null) ? $request->retailer_id : null;
        $customer_id = ($request->customer_id != null) ? $request->customer_id : null;
        $sales = $this->salesReportRepository->searchSalesReturn($showRoom_id, $retailer_id, $customer_id);

        return view('report::sales_report.sales_return_report', compact('sales', 'showrooms', 'customers', 'staffs', 'showRoom_id', 'customer_id'));
    }
}
