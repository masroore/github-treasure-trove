<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\AccountBalanceRepositoryInterface;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Report\Repositories\BalanceStatementReportRepository;

class AccountBalanceController extends Controller
{
    protected $balanceStatementRepositories;

    protected $openingBalanceHistoryRepository;

    protected $charAccountRepository;

    protected $accountBalanceRepository;

    public function __construct(BalanceStatementReportRepository $balanceStatementRepositories, ChartAccountRepositoryInterface $charAccountRepository, AccountBalanceRepositoryInterface $accountBalanceRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->balanceStatementRepositories = $balanceStatementRepositories;
        $this->accountBalanceRepository = $accountBalanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $dateFrom = null;
        $dateTo = null;
        if ($request->date_range) {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

            if ($request->date_range) {
                $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
                $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));

                $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
                $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
            }
        }

        $income = $this->accountBalanceRepository->getIncome($dateFrom ?? null, $dateTo ?? null);
        $expense = $this->accountBalanceRepository->getExpense($dateFrom ?? null, $dateTo ?? null);
        $asset = $this->accountBalanceRepository->getAsset($dateFrom ?? null, $dateTo ?? null);
        $liabilities = $this->accountBalanceRepository->getLiabilities($dateFrom ?? null, $dateTo ?? null);
        $equity = $this->accountBalanceRepository->getEquity($dateFrom ?? null, $dateTo ?? null);

        $data['asset'] = $asset;
        $data['liabilities'] = $liabilities;
        $data['expense'] = $expense;
        $data['income'] = $income;
        $data['equity'] = $equity;
        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;

        return view('account::account-balance.index', $data);
    }

    public function income_by_customer(Request $request)
    {
        $dateFrom = null;
        $dateTo = null;
        if ($request->date_range) {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

            if ($request->date_range) {
                $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
                $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));

                $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
                $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
            }
        }

        $chartAccount = $this->accountBalanceRepository->getIncomeByCustomer($dateFrom, $dateTo);

        return view('account::account-balance.income_by_customer', compact('chartAccount', 'dateFrom', 'dateTo'));
    }

    public function expense_by_supplier(Request $request)
    {
        $dateFrom = null;
        $dateTo = null;
        if ($request->date_range) {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

            if ($request->date_range) {
                $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
                $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));

                $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
                $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
            }
        }

        $chartAccount = $this->accountBalanceRepository->getExpenseBySupplier($dateFrom, $dateTo);

        return view('account::account-balance.expense_by_supplier', compact('chartAccount', 'dateFrom', 'dateTo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function sale_tax(Request $request)
    {
        if ($request->date_range) {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

            if ($request->date_range) {
                $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
                $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));

                $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
                $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
            }
        }

        $tax = $this->accountBalanceRepository->saleTax($dateFrom ?? null, $dateTo ?? null);

        return view('account::account-balance.sale_tax', compact('tax'));
    }

    public function income(Request $request)
    {
        $formDate = $toDate = null;
        if ($request->date_from && $request->date_to) {
            $formDate = Carbon::parse($request->date_from)->format('Y-m-d');
            $toDate = Carbon::parse($request->date_to)->format('Y-m-d');
        }

        $income = $this->accountBalanceRepository->income($formDate, $toDate);
        $expense = $this->accountBalanceRepository->expense($formDate, $toDate);

        return view('account::account-balance.income', compact('income', 'expense', 'formDate', 'toDate'));
    }
}
