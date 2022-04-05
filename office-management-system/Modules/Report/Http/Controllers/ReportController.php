<?php

namespace Modules\Report\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Report\Repositories\ReportRepositoryInterface;

class ReportController extends Controller
{
    protected $reportReportRepository;

    protected $contactRepositories;

    protected $showRoomRepository;

    protected $wareHouseRepository;

    protected $productRepository;

    public function __construct(
        ReportRepositoryInterface $reportReportRepository,
        ContactRepositoriesInterface $contactRepositories,
        WareHouseRepositoryInterface $wareHouseRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->reportReportRepository = $reportReportRepository;
        $this->contactRepositories = $contactRepositories;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        try {
            $opening_balances = $this->reportReportRepository->all();
            $type = null;
            if ($request->type != null) {
                $type = $request->type;
                $opening_balances = $this->reportReportRepository->search($type);
            }

            return view('report::opening_balance_report.index', compact('opening_balances', 'type'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function packingReport()
    {
        $data = [
            'suppliers' => $this->contactRepositories->supplier(),
            'showrooms' => $this->showRoomRepository->activeShoowroom(),
            'warehouses' => $this->wareHouseRepository->activeWarehouse(),
        ];

        return view('report::packing_report.index')->with($data);
    }

    public function packingSearch(Request $request)
    {
        $request->validate([
            'house_id' => 'required_without_all:supplier_id,from_date,to_date,receive',
            'supplier_id' => 'required_without_all:house_id,from_date,to_date,receive',
            'from_date' => 'required_without_all:house_id,supplier_id,to_date,receive',
            'to_date' => 'required_without_all:house_id,supplier_id,from_date,receive',
            'receive' => 'required_without_all:house_id,supplier_id,from_date,to_Date',
        ]);

        $packings = $this->reportReportRepository->packing($request->house_id, $request->supplier_id, $request->from_date, $request->to_date, $request->receive);

        $data = [
            'house_id' => $request->house_id,
            'receive' => $request->receive,
            'supplier_id' => $request->supplier_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'packings' => $packings,
            'suppliers' => $this->contactRepositories->supplier(),
            'showrooms' => $this->showRoomRepository->activeShoowroom(),
            'warehouses' => $this->wareHouseRepository->activeWarehouse(),
        ];

        return view('report::packing_report.index')->with($data);
    }

    public function productPacking()
    {
        $data = [
            'productSkus' => $this->productRepository->allProduct(),
        ];

        return view('report::packing_report.packing_product')->with($data);
    }

    public function productRcvPacking()
    {
        $data = [
            'productSkus' => $this->productRepository->allProduct(),
        ];

        return view('report::packing_report.packing_rcv_product')->with($data);
    }

    public function productPackingSearch(Request $request)
    {
        $request->validate([
            'from_date' => 'required_without_all:to_date,productSku_id',
            'to_date' => 'required_without_all:from_date,productSku_id',
            'productSku_id' => 'required_without_all:from_date,to_date',
        ]);
        $items = $this->reportReportRepository->packingSearch($request->productSku_id, $request->from_date, $request->to_date);

        $data = [
            'productSkus' => $this->productRepository->allProduct(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'productSku_id' => $request->productSku_id,
            'items' => $items,
        ];

        return view('report::packing_report.packing_product')->with($data);
    }

    public function productRcvPackingSearch(Request $request)
    {
        $request->validate([
            'from_date' => 'required_without_all:to_date,productSku_id',
            'to_date' => 'required_without_all:from_date,productSku_id',
            'productSku_id' => 'required_without_all:from_date,to_date',
        ]);
        $items = $this->reportReportRepository->packingRcvSearch($request->productSku_id, $request->from_date, $request->to_date);

        $data = [
            'productSkus' => $this->productRepository->allProduct(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'productSku_id' => $request->productSku_id,
            'items' => $items,
        ];

        return view('report::packing_report.packing_rcv_product')->with($data);
    }

    public function serial_index_report()
    {
        $data['serials'] = $this->reportReportRepository->serialAll();

        return view('report::serial_report.serial_index_report')->with($data);
    }
}
