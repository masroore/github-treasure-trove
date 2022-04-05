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

class CustomerReportController extends Controller
{
    public $charAccountRepository;

    public $contactRepository;

    public function __construct(ChartAccountRepositoryInterface $charAccountRepository, ContactRepositoriesInterface $contactRepository)
    {
        $this->charAccountRepository = $charAccountRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $customers = $this->contactRepository->customer();

            return view('report::customer_report.index', compact('customers'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function showHistory(Request $request, $id)
    {
        try {
            $customer = $this->contactRepository->find($id);
            $chartAccountId = $this->charAccountRepository->getFirst('Modules\Contact\Entities\ContactModel', $id);
            $opening_balance = $customer->opening_balance ?: 0;
            $currentBalance = 0 + $opening_balance;
            foreach ($chartAccountId->transactions as $key => $payment) {
                $payment->type == 'Dr' ? $currentBalance += $payment->amount : $currentBalance -= $payment->amount;
            }
            $account_id = $id;
            if ($request->has('print')) {
                $chartAccount = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $account_id)->first();

                return view('report::customer_report.print_view', compact('account_id', 'customer', 'currentBalance', 'chartAccount'));
            }

            return view('report::customer_report.history', compact('account_id', 'customer', 'currentBalance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
