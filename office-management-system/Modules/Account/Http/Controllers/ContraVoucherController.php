<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Http\Requests\JournalFormRequest;
use Modules\Account\Repositories\ContraRepositoryInterface;
use Toastr;

class ContraVoucherController extends Controller
{
    protected $contraRepository;

    public function __construct(ContraRepositoryInterface $contraRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->contraRepository = $contraRepository;
    }

    public function index()
    {
        $journals = $this->contraRepository->journal_all();

        return view('account::contra_vouchers.index', [
            'journals' => $journals,
        ]);
    }

    public function create()
    {
        $accounts = $this->contraRepository->all();

        return view('account::contra_vouchers.create', [
            'accounts' => $accounts,
        ]);
    }

    public function store(JournalFormRequest $request)
    {
        $sub_amount = 0;
        foreach ($request->sub_amount as $key => $amount) {
            $sub_amount += $amount;
        }
        if ($request->main_amount == $sub_amount) {
            DB::beginTransaction();

            try {
                $this->contraRepository->create([
                    'voucher_type' => 'CRV',
                    'amount' => $request->main_amount,
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'account_type' => $request->account_type,
                    'payment_type' => 'contra_voucher',
                    'account_id' => $request->account_id,  //debit side and credit side shoud be same
                    'main_amount' => $request->main_amount,  //debit side and credit side shoud be same
                    'narration' => $request->narration,  //debit side and credit side shoud be same

                    'sub_account_id' => $request->sub_account_id,   //debit side and credit side shoud be same
                    'sub_amount' => $request->sub_amount,
                    'sub_narration' => $request->sub_narration,
                    'is_approve' => (app('business_settings')->where('type', 'contra_voucher_approval')->first()->status == 1) ? 1 : 0,
                ]);
                DB::commit();
                LogActivity::successLog('Contra voucher has been added.');
                Toastr::success(__('account.Contra Voucher has been added Successfully'));

                return redirect()->route('contra.index');
            } catch (Exception $e) {
                DB::rollBack();
                LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Journal creation');
                Toastr::error(__('common.Something Went Wrong'));

                return back();
            }
        } else {
            Toastr::error(__('account.Debit and Credit amount was mismatched.'));

            return back();
        }
    }

    public function edit($id)
    {
        $journal = $this->contraRepository->find($id);
        $accounts = $this->contraRepository->all();

        return view('account::contra_vouchers.edit', [
            'journal' => $journal,
            'accounts' => $accounts,
        ]);
    }

    public function update(JournalFormRequest $request, $id)
    {
        $sub_amount = 0;
        foreach ($request->sub_amount as $key => $amount) {
            $sub_amount += $amount;
        }
        if ($request->main_amount == $sub_amount) {
            DB::beginTransaction();

            try {
                $this->contraRepository->update([
                    'voucher_type' => 'CRV',
                    'amount' => $request->main_amount,
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'account_type' => $request->account_type,
                    'payment_type' => 'contra_voucher',
                    'account_id' => $request->account_id,  //debit side and credit side shoud be same
                    'main_amount' => $request->main_amount,  //debit side and credit side shoud be same
                    'narration' => $request->narration,  //debit side and credit side shoud be same

                    'sub_account_id' => $request->sub_account_id,   //debit side and credit side shoud be same
                    'sub_amount' => $request->sub_amount,
                    'sub_narration' => $request->sub_narration,
                    'is_approve' => (app('business_settings')->where('type', 'contra_voucher_approval')->first()->status == 1) ? 1 : 0,
                ], $id);
                DB::commit();
                LogActivity::successLog('Contra Voucher has been updated.');
                Toastr::success(__('account.Contra Voucher has been updated Successfully'));

                return redirect()->route('contra.index');
            } catch (Exception $e) {
                DB::rollBack();
                LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Payment creation');
                Toastr::error(__('common.Something Went Wrong'));

                return back();
            }
        } else {
            Toastr::error(__('account.Debit and Credit amount was mismatched.'));

            return back();
        }
    }
}
