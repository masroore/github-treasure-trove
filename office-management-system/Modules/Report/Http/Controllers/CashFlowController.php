<?php

namespace Modules\Report\Http\Controllers;

use App\Traits\Accounts;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\OpeningBalanceHistoryRepositoryInterface;
use Modules\Report\Repositories\CashFlowReportRepositoryInterface;

class CashFlowController extends Controller
{
    use Accounts;

    protected $incomeStatementRepositories;

    protected $openingBalanceHistoryRepository;

    protected $charAccountRepository;

    public function __construct(CashFlowReportRepositoryInterface $cashFlowStatementRepositories, OpeningBalanceHistoryRepositoryInterface $openingBalanceHistoryRepository, ChartAccountRepositoryInterface $charAccountRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->cashFlowStatementRepositories = $cashFlowStatementRepositories;
        $this->openingBalanceHistoryRepository = $openingBalanceHistoryRepository;
    }

    public function index(Request $request)
    {
        if ($request->dateTo != null && $request->dateFrom == null) {
            Toastr::warning(__('report.You need to set date-from when you select date-to.'));

            return back();
        }
        if ($request->dateTo == null && $request->dateFrom != null) {
            Toastr::warning(__('report.You need to set date-to when you select date-from.'));

            return back();
        }
        if ($request->dateTo != null && $request->dateFrom != null) {
            $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
            $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;
            $cashflowSatementsPayments = $this->cashFlowStatementRepositories->payments($dateFrom, $dateTo)->where('type', 'Cr');
            $cashflowSatementsRecieves = $this->cashFlowStatementRepositories->recieves($dateFrom, $dateTo)->where('type', 'Dr');

            if ($cashflowSatementsPayments != null || $cashflowSatementsRecieves != null) {
                $set = 1;

                return view('report::cash_flows.index', compact('dateFrom', 'dateTo', 'cashflowSatementsPayments', 'cashflowSatementsRecieves', 'set'));
            }
            Toastr::error(__('common.No data Found'));

            return view('report::cash_flows.index', compact('dateFrom', 'dateTo'));
        }

        return view('report::cash_flows.index');
    }
}
