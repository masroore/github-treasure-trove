<?php

namespace Modules\Account\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\LedgerReportRepositoryInterface;

class TransactionController extends Controller
{
    protected $transactionRepository;

    protected $charAccountRepository;

    public function __construct(ChartAccountRepositoryInterface $charAccountRepository, LedgerReportRepositoryInterface $leadgerRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->leadgerRepository = $leadgerRepository;
    }

    public function index(Request $request)
    {
        try {
            $accounts = $this->charAccountRepository->all();
            if ($request->dateTo != null && $request->dateFrom == null) {
                Toastr::warning(__('report.You need to set date-from when you select date-to.'));

                return back();
            }
            if ($request->dateTo == null && $request->dateFrom != null) {
                Toastr::warning(__('report.You need to set date-to when you select date-from.'));

                return back();
            }
            $beforedateAccount = null;
            $accont_type = null;
            $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
            $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;
            $account_id = ($request->account_id != null) ? $request->account_id : null;
            if ($request->account_id != null) {
                $beforedateAccount = ChartAccount::findOrFail($request['account_id']);
                $balance = $this->leadgerRepository->balanceBeforeDate($dateFrom, $beforedateAccount);
                $accont_type = $beforedateAccount->type;
                $opening_balance = OpeningBalanceHistory::where('account_id', $request['account_id'])->where('is_default', 0)->sum('amount');
            } else {
                $balance = 0;
                $opening_balance = 0;
            }
            if (!$account_id) {
                $transactions = null;
            } else {
                $transactions = $this->leadgerRepository->search($dateFrom, $dateTo, $account_id);
            }

            return view('account::leadger_report.index', compact('transactions', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount', 'opening_balance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function delete($id)
    {
        try {
            $this->transactionRepository->delete($id);
            LogActivity::successLog('Transaction deleted.');
            Toastr::success(__('Transaction deleted'));

            return redirect()->back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been Transaction deleted');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function search(Request $request)
    {
        $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

        if ($request->date_range) {
            $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
            $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));
        }

        $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
        $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
        $voucher_type = ($request->voucher_type != null) ? $request->voucher_type : null;
        $payment_type = ($request->payment_type != null) ? $request->payment_type : null;
        $is_approve = ($request->is_approve != null) ? $request->is_approve : null;
        $account_type = ($request->account_type != null) ? $request->account_type : null;
        $data['transactionLists'] = $this->transactionRepository->search($dateFrom, $dateTo, $voucher_type, $payment_type, $is_approve, $account_type);
        $data['dateFrom'] = $request->dateFrom;
        $data['dateTo'] = $request->dateTo;
        $data['voucher_type'] = $request->voucher_type;
        $data['payment_type'] = $request->payment_type;
        $data['is_approve'] = $request->is_approve;

        return view('account::transactions.index', $data);
    }
}
