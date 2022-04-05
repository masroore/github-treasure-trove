<?php

namespace Modules\Report\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Report\Repositories\PurchaseReportRepositoryInterface;

class PurchaseReportController extends Controller
{
    protected $purchaseReportRepository;

    protected $showRoomRepository;

    protected $contactRepository;

    protected $productRepository;

    protected $wareHouseRepository;

    public function __construct(PurchaseReportRepositoryInterface $purchaseReportRepository, ContactRepositoriesInterface $contactRepository, ShowRoomRepositoryInterface $showRoomRepository, ProductRepositoryInterface $productRepository, WareHouseRepositoryInterface $wareHouseRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->purchaseReportRepository = $purchaseReportRepository;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->contactRepository = $contactRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $showrooms = $this->showRoomRepository->all();
        $warehouses = $this->wareHouseRepository->all();
        $suppliers = $this->contactRepository->supplier();
        if ($request->showRoom_id != null && $request->warehouse_id != null) {
            Toastr::warning(__('report.You need to choose either ShowRoom or WareHouse'));

            return back();
        }
        $type = ($request->type != null) ? $request->type : null;
        $showRoom_id = ($request->showRoom_id != null) ? $request->showRoom_id : null;
        $warehouse_id = ($request->warehouse_id != null) ? $request->warehouse_id : null;
        $supplier_id = ($request->supplier_id != null) ? $request->supplier_id : null;
        $orders = $this->purchaseReportRepository->search($showRoom_id, $supplier_id, $warehouse_id, $type);

        return view('report::puchases_report.index', compact('orders', 'showrooms', 'suppliers', 'warehouses', 'type', 'warehouse_id', 'showRoom_id', 'supplier_id'));
    }

    public function product_purchase_index(Request $request)
    {
        $productSkus = $this->productRepository->allProduct();
        $productSku_id = ($request->productSku_id != null) ? $request->productSku_id : null;
        $orders = $this->purchaseReportRepository->searchProduct($productSku_id);

        return view('report::puchases_report.product_purchase_report', compact('orders', 'productSkus', 'productSku_id'));
    }
}
