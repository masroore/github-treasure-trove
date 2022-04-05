<?php

namespace Modules\Account\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Repositories\BankAccountRepositoryInterface;

class BankAccountController extends Controller
{
    protected $accountRepository;

    public function __construct(BankAccountRepositoryInterface $accountRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $bank_accounts = $this->accountRepository->all();

        return view('account::bank_accounts.bank_accounts', compact('bank_accounts'));
    }

    public function create()
    {
        $bank_accounts = $this->accountRepository->all();

        return view('account::bank_accounts.page_component.bank_accounts_list', compact('bank_accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|unique:bank_accounts',
            'branch_name' => 'required',
            'account_no' => 'required',
        ]);

        try {
            $this->accountRepository->create($request->except('_token'));

            LogActivity::successLog('New Account Added Successfully');

            return response()->json(['success' => trans('account.New Account Added Successfully')], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => trans('common.Something Went Wrong')], 503);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit($id)
    {
        return view('account::edit');
    }

    public function update(Request $request)
    {
        try {
            $this->accountRepository->update($request->except('_token'));
            LogActivity::successLog('Chart of Account Updated Successfully');

            return response()->json(['success' => trans('account.Bank Account Updated Successfully')], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => trans('common.Something Went Wrong')], 503);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->accountRepository->delete($request->id);
            LogActivity::successLog('An Account deleted Successfully');

            return response()->json(['success' => trans('account.Bank Account Deleted Successfully')], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => trans('common.Something Went Wrong')], 503);
        }
    }

    public function showHistory($id)
    {
        try {
            $bank = $this->accountRepository->find($id);
            $chartAccount = $bank->chartAccount;
            $opening_balance = OpeningBalanceHistory::where('account_id', $bank->chart_account_id)->where('is_default', 0)->sum('amount');

            $currentBalance = 0 + $opening_balance;

            foreach ($chartAccount->transactions as $key => $payment) {
                ($payment->type == 'Dr') ? ($currentBalance += $payment->amount) : ($currentBalance -= $payment->amount);
            }

            return view('account::bank_accounts.history', compact('bank', 'chartAccount', 'currentBalance', 'opening_balance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function csv_upload()
    {
        return view('account::bank_accounts.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->accountRepository->csv_upload_bank_account($request->except('_token'));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            } else {
                Toastr::error('Something went wrong. Upload again !!!');
            }

            return back();
        }
    }
}
