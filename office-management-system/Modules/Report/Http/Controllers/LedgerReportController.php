<?php

namespace Modules\Report\Http\Controllers;

use App\Traits\PdfGenerate;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Mail;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Report\Repositories\LedgerReportRepositoryInterface;
use Modules\Setting\Model\EmailTemplate;
use PDF;

class LedgerReportController extends Controller
{
    use PdfGenerate;

    protected $charAccountRepository;

    protected $leadgerRepository;

    public function __construct(
        ChartAccountRepositoryInterface $charAccountRepository,
        LedgerReportRepositoryInterface $leadgerRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->leadgerRepository = $leadgerRepository;
    }

    public function index(Request $request)
    {
        try {
            $accounts = $this->charAccountRepository->all();
            $beforedateAccount = null;
            $accont_type = null;
            $dateFrom = ($request->dateFrom != null) ? Carbon::parse($request->dateFrom)->format('Y-m-d') : null;
            $dateTo = ($request->dateTo != null) ? Carbon::parse($request->dateTo)->format('Y-m-d') : null;
            $account_id = ($request->account_id != null) ? $request->account_id : null;

            if ($dateFrom != null && $dateTo != null && $account_id == null) {
                Toastr::warning('Select Account First');

                return view('report::leadger_report.index', compact('accont_type', 'accounts', 'dateFrom', 'dateTo'));
            }
            if ($dateTo != null && $dateFrom == null) {
                Toastr::warning(__('report.You need to set date-from when you select date-to.'));

                return view('report::leadger_report.index', compact('accont_type', 'accounts', 'dateTo'));
            }
            if ($dateTo == null && $dateFrom != null) {
                Toastr::warning(__('report.You need to set date-to when you select date-from.'));

                return view('report::leadger_report.index', compact('accont_type', 'accounts', 'dateFrom'));
            }
            if ($account_id != null) {
                $beforedateAccount = ChartAccount::findOrFail($request['account_id']);
                $balance = $this->leadgerRepository->balanceBeforeDate($dateFrom, $beforedateAccount);
                $accont_type = $beforedateAccount->type;
                $opening_balance = OpeningBalanceHistory::where('account_id', $account_id)->where('is_default', 0)->sum('amount');
                $transactions = $this->leadgerRepository->search($dateFrom, $dateTo, $account_id);
                if ($request->has('mail') && $beforedateAccount->contactable->email != null) {
                    $datas['email'] = app('general_setting')->email;
                    $datas['title'] = EmailTemplate::where('type', 'transaction_mail_template')->first()->subject;
                    $datas['body'] = EmailTemplate::where('type', 'transaction_mail_template')->first()->value;
                    $datas['body'] = str_replace('{USER_FIRST_NAME}', $beforedateAccount->contactable->email, $datas['body']);
                    $datas['body'] = str_replace('{USER_LOGIN_EMAIL}', $beforedateAccount->contactable->email, $datas['body']);
                    $datas['body'] = str_replace('{EMAIL_SIGNATURE}', app('general_setting')->mail_signature, $datas['body']);
                    $datas['body'] = str_replace('{EMAIL_FOOTER}', app('general_setting')->mail_footer, $datas['body']);
                    $pdf = PDF::loadView('report::leadger_report.pdf', compact('transactions', 'opening_balance', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount'))->setPaper('a4', 'portrait');

                    Mail::send('report::leadger_report.mail', $datas, function ($message) use ($beforedateAccount, $datas, $pdf): void {
                        $message->to($beforedateAccount->contactable->email, $beforedateAccount->contactable->email)
                            ->subject($datas['title'])
                            ->attachData($pdf->output(), date('y-m-d') . '-Transaction.pdf');
                    });
                }
                if (!$request->has('print')) {
                    return view('report::leadger_report.index', compact('transactions', 'opening_balance', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount'));
                }

                return view('report::leadger_report.print_view', compact('transactions', 'opening_balance', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount'));
            }

            return view('report::leadger_report.index', compact('accont_type', 'accounts'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function print_view(Request $request)
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

            $transactions = $this->leadgerRepository->search($dateFrom, $dateTo, $account_id);

            return view('report::leadger_report.print_view', compact('transactions', 'opening_balance', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
