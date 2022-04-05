<?php

namespace Modules\Report\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Contact\Repositories\ContactRepositoriesInterface;

class SupplierReportController extends Controller
{
    public $contactRepository;

    public $charAccountRepository;

    public function __construct(ContactRepositoriesInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        try {
            $suppliers = $this->contactRepository->supplier();

            return view('report::supplier_report.index', compact('suppliers'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function showHistory(ChartAccountRepositoryInterface $charAccountRepository, Request $request, $id)
    {
        try {
            $supplier = $this->contactRepository->find($id);
            $chartAccountId = $charAccountRepository->getFirst('Modules\Contact\Entities\ContactModel', $id);
            $opening_balance = $supplier->opening_balance ?: 0;
            $currentBalance = 0 + $opening_balance;
            foreach ($chartAccountId->transactions as $key => $payment) {
                $payment->type == 'Dr' ? $currentBalance += $payment->amount : $currentBalance -= $payment->amount;
            }

            $account_id = $id;
            if ($request->has('print')) {
                $chartAccount = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $account_id)->first();

                return view('report::supplier_report.print_view', compact('account_id', 'supplier', 'currentBalance', 'chartAccount'));
            }

            return view('report::supplier_report.history', compact('supplier', 'account_id', 'currentBalance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
