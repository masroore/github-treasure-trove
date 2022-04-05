<?php

namespace Modules\Account\Http\Controllers;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Contact\Entities\ContactModel;
use Modules\Sale\Repositories\SaleRepositoryInterface;

class VoucherRecieveController extends Controller
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $payments = $this->voucherRepository->voucher_recieve_all();

        return view('account::voucher_recieves.index', [
            'payments' => $payments,
        ]);
    }

    public function create()
    {
        $recieve_from_accounts = $this->voucherRepository->recieveCategoryAccounts();
        $recieve_by_accounts = $this->voucherRepository->get_recieveByAccount_account();

        return view('account::voucher_recieves.create', [
            'recieve_from_accounts' => $recieve_from_accounts,
            'recieve_by_accounts' => $recieve_by_accounts,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'voucher_type' => 'required',
            'narration' => 'nullable',
            'cheque_no' => 'nullable',
            'cheque_date' => 'nullable',
            'bank_name' => 'nullable',
            'bank_branch' => 'nullable',
            'debit_account_id' => 'required',
            'debit_account_amount.*' => 'required',
            'debit_account_narration' => 'nullable',

        ]);
        DB::beginTransaction();

        try {
            $debit_account_amount = 0;
            foreach ($request->debit_account_amount as $key => $amount) {
                $debit_account_amount += $amount;
            }
            $this->voucherRepository->create([
                'voucher_type' => $request->voucher_type == 1 ? 'CV' : 'BV',
                'amount' => $debit_account_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'payment_type' => 'voucher_recieve',
                'credit_account_id' => $request->credit_account_id,
                'credit_account_amount' => $debit_account_amount,
                'credit_account_narration' => $request->narration,
                'debit_account_id' => $request->debit_account_id,
                'debit_account_amount' => $request->debit_account_amount,
                'debit_account_narration' => $request->debit_account_narration,

                'narration' => $request->narration,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'invoice_id' => ($request->invoice_id) ? $request->invoice_id : null,
                'is_approve' => (app('business_settings')->where('type', 'voucher_recieve_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Voucher Recieve has been Added.');
            Toastr::success(__('account.Voucher Recieve has been added Successfully'));

            return redirect()->route('voucher_recieve.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Voucher Recieve creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show($id)
    {
        $payment = $this->voucherRepository->find($id);

        return view('account::voucher_approvals.view', [
            'payment' => $payment,
        ]);
    }

    public function edit($id)
    {
        $recieve = $this->voucherRepository->find($id);
        $recieve_from_accounts = $this->voucherRepository->recieveCategoryAccounts();
        $recieve_by_accounts = $this->voucherRepository->get_recieveByAccount_account();
        $selected_recieve_from_account_id = $recieve->transactions->where('type', 'Cr')->first()->account_id;
        $selected_recieve_by_account_id = $recieve->transactions->where('type', 'Dr')->first()->account_id;

        return view('account::voucher_recieves.edit', [
            'recieve' => $recieve,
            'recieve_from_accounts' => $recieve_from_accounts,
            'recieve_by_accounts' => $recieve_by_accounts,
            'selected_recieve_from_account_id' => $selected_recieve_from_account_id,
            'selected_recieve_by_account_id' => $selected_recieve_by_account_id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'nullable',
            'voucher_type' => 'required',
            'narration' => 'nullable',
            'cheque_no' => 'nullable',
            'cheque_date' => 'nullable',
            'bank_name' => 'nullable',
            'bank_branch' => 'nullable',
            'debit_account_id' => 'nullable',
            'debit_account_amount' => 'nullable',
            'debit_account_narration' => 'nullable',

        ]);

        DB::beginTransaction();

        try {
            $debit_account_amount = 0;
            foreach ($request->debit_account_amount as $key => $amount) {
                $debit_account_amount += $amount;
            }
            $this->voucherRepository->update([
                'voucher_type' => $request->voucher_type == 1 ? 'CV' : 'BV',
                'amount' => $debit_account_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'payment_type' => 'voucher_recieve',
                'credit_account_id' => $request->credit_account_id,
                'credit_account_amount' => $debit_account_amount,
                'credit_account_narration' => $request->narration,

                'debit_account_id' => $request->debit_account_id,
                'debit_account_amount' => $request->debit_account_amount,
                'debit_account_narration' => $request->debit_account_narration,

                'narration' => $request->narration,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'is_approve' => (app('business_settings')->where('type', 'voucher_recieve_approval')->first()->status == 1) ? 1 : 0,
            ], $id);
            DB::commit();
            LogActivity::successLog('Payment has been updated.');
            Toastr::success(__('account.Voucher Recieve has been updated Successfully'));

            return redirect()->route('voucher_recieve.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Voucher Recieve creation');

            return back()->with('message-danger', __('common.Something Went Wrong'));
        }
    }

    public function get_accounts_configurable_type(Request $request)
    {
        return $this->voucherRepository->findChartAccount($request->except('_token', 'permissions', 'sub_menu'));
    }

    public function get_invoice_lists(Request $request, SaleRepositoryInterface $saleRepository)
    {
        $chart_account = $this->voucherRepository->findChartAccount($request->except('_token'));
        if ($chart_account->contactable_type == ContactModel::class) {
            $inovices = $saleRepository->customerInvoiceList($chart_account->contactable_id);

            return view('account::voucher_recieves.invoices', [
                'inovices' => $inovices,
            ]);
        } elseif ($chart_account->contactable_type == User::class) {
            $inovices = $saleRepository->retailerInvoiceList($chart_account->contactable_id);

            return view('account::voucher_recieves.invoices', [
                'inovices' => $inovices,
            ]);
        }

        return 0;
    }
}
