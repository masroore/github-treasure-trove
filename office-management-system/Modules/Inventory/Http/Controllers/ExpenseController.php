<?php

namespace Modules\Inventory\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Repositories\VoucherRepositoryInterface;
use Modules\Inventory\Http\Requests\ExpenseFormRequest;
use Modules\Inventory\Repositories\ExpenseRepositoryInterface;

class ExpenseController extends Controller
{
    protected $expenseRepository;

    protected $voucherRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository, VoucherRepositoryInterface $voucherRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->expenseRepository = $expenseRepository;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $expenses = $this->expenseRepository->expenceList();

        return view('inventory::expenses.index', [
            'expenses' => $expenses,
        ]);
    }

    public function create()
    {
        $accounts = $this->expenseRepository->expenceAccount();
        $account_categories = $this->voucherRepository->category();

        return view('inventory::expenses.create', [
            'accounts' => $accounts,
            'account_categories' => $account_categories,
        ]);
    }

    public function store(ExpenseFormRequest $request)
    {
        $sub_amount = 0;
        foreach ($request->sub_amount as $key => $amount) {
            $sub_amount += $amount;
        }
        $account_id = $request->credit_account_id;

        try {
            $this->expenseRepository->create([
                'voucher_type' => $request->voucher_type == 1 ? 'CV' : 'BV', //modified
                'amount' => $sub_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'account_type' => 'credit',
                'payment_type' => 'contra_voucher',
                'account_id' => $account_id,  //debit side and credit side shoud be same
                'main_amount' => $sub_amount,  //debit side and credit side shoud be same
                'narration' => $request->narration,  //debit side and credit side shoud be same
                'sub_account_id' => $request->sub_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $request->sub_amount,
                'sub_narration' => $request->sub_narration,

                'cheque_no' => $request->cheque_no,
                'cheque_date' => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,

                'is_approve' => (app('business_settings')->where('type', 'expense_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Expense has been added Successfully.');
            Toastr::success(__('inventory.Expense has been added Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Expense creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit($id)
    {
        $expense = $this->expenseRepository->find($id);
        $accounts = $this->expenseRepository->expenceAccount();

        return view('inventory::expenses.edit', [
            'expense' => $expense,
            'accounts' => $accounts,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sub_amount = 0;
        foreach ($request->sub_amount as $key => $amount) {
            $sub_amount += $amount;
        }
        DB::beginTransaction();
        $account_id = $request->credit_account_id;

        try {
            $this->expenseRepository->update([
                'voucher_type' => 'CRV',
                'amount' => $sub_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'account_type' => 'debit',
                'payment_type' => 'contra_voucher',
                'account_id' => $account_id,  //debit side and credit side shoud be same
                'main_amount' => $sub_amount,  //debit side and credit side shoud be same
                'narration' => $request->narration,  //debit side and credit side shoud be same

                'sub_account_id' => $request->sub_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $request->sub_amount,
                'sub_narration' => $request->sub_narration,
                'is_approve' => (app('business_settings')->where('type', 'expense_voucher_approval')->first()->status == 1) ? 1 : 0,
            ], $id);
            DB::commit();
            LogActivity::successLog('Expense has been updated Successfully.');
            Toastr::success(__('inventory.Expense has been updated Successfully'));

            return redirect()->route('expenses.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Expense Update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $voucher = $this->expenseRepository->delete($id);
            LogActivity::successLog('Expense has been destroyed.');
            Toastr::success(__('inventory.Expense has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Expense Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
