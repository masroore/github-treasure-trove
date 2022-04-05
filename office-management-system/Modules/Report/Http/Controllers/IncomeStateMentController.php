<?php

namespace Modules\Report\Http\Controllers;

use App\Traits\Accounts;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\OpeningBalanceHistoryRepositoryInterface;
use Modules\Report\Repositories\IncomeStatementReportRepository;

class IncomeStateMentController extends Controller
{
    use Accounts;

    protected $incomeStatementRepositories;

    protected $openingBalanceHistoryRepository;

    protected $charAccountRepository;

    public function __construct(
        IncomeStatementReportRepository $incomeStatementRepositories,
        OpeningBalanceHistoryRepositoryInterface $openingBalanceHistoryRepository,
        ChartAccountRepositoryInterface $charAccountRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->incomeStatementRepositories = $incomeStatementRepositories;
        $this->openingBalanceHistoryRepository = $openingBalanceHistoryRepository;
    }

    public function index(Request $request)
    {
        $timePeriods = $this->openingBalanceHistoryRepository->all();
        if ($request->interval) {
            $timePeriod = $request->interval;
            $salesAccount = $this->charAccountRepository->find($this->defaultSalesAccount());
            $saleTransactionBalance = $this->incomeStatementRepositories->saleTransactionBalance($timePeriod);
            $costFoGoodsTransactionBalance = $this->incomeStatementRepositories->costFoGoodsTransactionBalance($timePeriod);
            $incomeSatements = $this->incomeStatementRepositories->search($timePeriod);
            $expenseAccounts = $this->charAccountRepository->expenseAccountList($timePeriod);
            $incomeAccounts = $this->charAccountRepository->incomeAccountList($timePeriod);
            if ($request->has('print')) {
                $timePeriod = TimePeriodAccount::find($request->interval);

                return view('report::income_statements.print_view', compact('timePeriods', 'timePeriod', 'salesAccount', 'incomeSatements', 'costFoGoodsTransactionBalance', 'saleTransactionBalance', 'expenseAccounts', 'incomeAccounts'));
            }

            return view('report::income_statements.index', compact('timePeriods', 'timePeriod', 'salesAccount', 'incomeSatements', 'costFoGoodsTransactionBalance', 'saleTransactionBalance', 'expenseAccounts', 'incomeAccounts'));
        }

        return view('report::income_statements.index', compact('timePeriods'));
    }

    public function dailyReport()
    {
        $expenseAccounts = $this->charAccountRepository->dailyExpense(Carbon::now()->format('Y-m-d'));
        $incomeAccounts = $this->charAccountRepository->dailyIncome(Carbon::now()->format('Y-m-d'));

        return view('report::income_statements.daily_report', compact('expenseAccounts', 'incomeAccounts'));
    }

    public function dailyReportSearch(Request $request)
    {
        $date = $request->date;
        $expenseAccounts = $this->charAccountRepository->dailyExpense(Carbon::parse($request->date)->format('Y-m-d'));
        $incomeAccounts = $this->charAccountRepository->dailyIncome(Carbon::parse($request->date)->format('Y-m-d'));

        return view('report::income_statements.daily_report', compact('date', 'incomeAccounts', 'expenseAccounts'));
    }

    public function showroom_income_expense_report(Request $request)
    {
        $data['showroomAccounts'] = $this->charAccountRepository->showroomAccounts()->pluck('id');
        $data['date'] = Carbon::parse($request->date)->format('Y-m-d') ?? Carbon::now()->format('Y-m-d');
        if ($request->dateTo != null && $request->dateFrom == null) {
            Toastr::warning(__('report.You need to set date-from when you select date-to.'));

            return back();
        }
        if ($request->dateTo == null && $request->dateFrom != null) {
            Toastr::warning(__('report.You need to set date-to when you select date-from.'));

            return back();
        }
        if ($request->dateFrom != null && $request->date != null) {
            $data['dateFrom'] = Carbon::parse($request->dateFrom)->format('Y-m-d') ?? null;
            $data['dateTo'] = Carbon::parse($request->dateTo)->format('Y-m-d') ?? null;
            $data['transactions'] = $this->incomeStatementRepositories->DateRangeWiseTransactionBalanceBranch($data['showroomAccounts'], $data['dateFrom'], $data['dateTo']);
            $data['no_of_accounts'] = $data['transactions']->unique('account_id');

            return view('report::showroom_statements.daily_report', $data);
        }

        $data['transactions'] = $this->incomeStatementRepositories->DateWiseTransactionBalanceBranch($data['showroomAccounts'], $data['date']);
        $data['no_of_accounts'] = $data['transactions']->unique('account_id');

        return view('report::showroom_statements.daily_report', $data);
    }
}
