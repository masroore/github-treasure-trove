<?php

namespace Modules\Report\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Report\Repositories\PurchaseReportRepositoryInterface;
use Modules\Report\Repositories\SalesReportRepositoryInterface;

class AccountsController extends Controller
{
    protected $contactRepositories;

    protected $purchaseReportRepository;

    public function __construct(ContactRepositoriesInterface $contactRepositories, PurchaseReportRepositoryInterface $purchaseReportRepository)
    {
        $this->contactRepositories = $contactRepositories;
        $this->purchaseReportRepository = $purchaseReportRepository;
    }

    public function supplier()
    {
        try {
            $data = [
                'suppliers' => $this->contactRepositories->supplier(),
            ];

            return view('report::bills.supplier')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function customer()
    {
        try {
            $data = [
                'customers' => $this->contactRepositories->customer(),
            ];

            return view('report::bills.customer')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function supplierBill(Request $request)
    {
        $request->validate([
            'from_date' => 'required_without_all:supplier_id,to_date',
            'to_date' => 'required_without_all:supplier_id,from_date',
            'supplier_id' => 'required_without_all:from_date,to_date',
        ]);

        try {
            $accounts = $this->purchaseReportRepository->accounts($request->from_date, $request->to_date, $request->supplier_id);

            $data = [
                'suppliers' => $this->contactRepositories->supplier(),
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'supplier_id' => $request->supplier_id,
                'accounts' => $accounts,
            ];

            return view('report::bills.supplier')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function customerBill(Request $request, SalesReportRepositoryInterface $salesReportRepository)
    {
        $request->validate([
            'from_date' => 'required_without_all:customer_id,to_date',
            'to_date' => 'required_without_all:customer_id,from_date',
            'customer_id' => 'required_without:from_date,to_date',
        ]);

        $accounts = $salesReportRepository->accounts($request->from_date, $request->to_date, $request->customer_id);

        $data = [
            'customers' => $this->contactRepositories->customer(),
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'customer_id' => $request->customer_id,
            'accounts' => $accounts,
        ];

        return view('report::bills.customer')->with($data);
    }
}
