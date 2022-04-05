<?php

namespace Modules\Account\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\IncomeRepositoryInterface;

class IncomeController extends Controller
{
    public $incomeRepository;

    public function __construct(IncomeRepositoryInterface $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $incomes = $this->incomeRepository->expenceList();

        return view('account::income.index', [
            'incomes' => $incomes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $accounts = $this->incomeRepository->expenceAccount();

        return view('account::income.create', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        $chartAccount = ChartAccount::find($request->account_id);

        $account_type = 'credit';
        if (in_array($chartAccount->type, [1, 3])) {
            $account_type = 'debit';
        }

        try {
            $this->incomeRepository->create([
                'voucher_type' => 'INC',
                'amount' => $request->amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),

                'account_type' => $account_type,
                'payment_type' => 'cash_voucher',
                'account_id' => $request->account_id,
                'narration' => $request->narration,
                'note' => $request->note,
                'is_approve' => (app('business_settings')->where('type', 'expense_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Income has been added Successfully.');
            Toastr::success(__('inventory.Income has been added Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Income creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
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
        $income = $this->incomeRepository->find($id);
        $accounts = $this->incomeRepository->expenceAccount();

        return view('account::income.edit', [
            'income' => $income,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $chartAccount = ChartAccount::find($request->account_id);

        $account_type = 'credit';
        if (in_array($chartAccount->type, [1, 3])) {
            $account_type = 'debit';
        }

        try {
            $this->incomeRepository->update([
                'voucher_type' => 'INC',
                'amount' => $request->amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),

                'account_type' => $account_type,
                'payment_type' => 'cash_voucher',
                'account_id' => $request->account_id,
                'narration' => $request->narration,
                'note' => $request->note,
                'is_approve' => (app('business_settings')->where('type', 'expense_voucher_approval')->first()->status == 1) ? 1 : 0,

            ], $id);
            DB::commit();
            LogActivity::successLog('Income has been updated Successfully.');
            Toastr::success(__('inventory.Income has been updated Successfully'));

            return redirect()->route('income.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Income Update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $voucher = $this->incomeRepository->delete($id);
            LogActivity::successLog('Income has been destroyed.');
            Toastr::success(__('inventory.Income has been deleted Successfully'));

            return redirect()->route('income.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Income Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return redirect()->route('income.index');
        }
    }
}
