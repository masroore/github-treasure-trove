<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\TransferRepositoryInterface;
use Toastr;

class TransferController extends Controller
{
    protected $transferRepository;

    public function __construct(TransferRepositoryInterface $transferRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->transferRepository = $transferRepository;
    }

    public function index()
    {
        $data['payments'] = $this->transferRepository->indexList();

        return view('account::transfers.index', $data);
    }

    public function showroom_create()
    {
        $data['chartAccounts'] = $this->transferRepository->allShowroomAccounts();

        return view('account::transfers.transfer_to_showroom', $data);
    }

    public function edit($id)
    {
        $data['payment'] = $this->transferRepository->find($id);
        $data['chartAccounts'] = $this->transferRepository->allShowroomAccounts();
        $data['payment_accounts'] = ChartAccount::PaymentAccounts()->get();

        return view('account::transfers.transfer_to_showroom_edit', $data);
    }

    public function showroom_store(Request $request)
    {
        $sub_amount = 0;
        foreach ($request->debit_account_amount as $key => $amount) {
            $sub_amount += $amount;
        }
        DB::beginTransaction();

        try {
            $this->transferRepository->create([
                'voucher_type' => 'CRV',
                'amount' => $sub_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'account_type' => 'credit',
                'payment_type' => 'contra_voucher',
                'account_id' => $request->credit_account_id,  //debit side and credit side shoud be same
                'main_amount' => $sub_amount,  //debit side and credit side shoud be same
                'narration' => $request->debit_account_narration[0],  //debit side and credit side shoud be same

                'sub_account_id' => $request->debit_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $request->debit_account_amount,
                'sub_narration' => $request->debit_account_narration,
                'is_approve' => (app('business_settings')->where('type', 'contra_voucher_approval')->first()->status == 1) ? 1 : 0,
                'is_transfer' => 1,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => ($request->cheque_date != null) ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
            ]);
            DB::commit();
            LogActivity::successLog('Money Transfer Successfully.');
            Toastr::success(__('account.Contra Voucher has been added Successfully'));

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Journal creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
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
            $sub_amount = 0;
            foreach ($request->debit_account_amount as $key => $amount) {
                $sub_amount += $amount;
            }
            $voucher = $this->transferRepository->update([
                'voucher_type' => 'CRV',
                'amount' => $sub_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'account_type' => 'debit',
                'payment_type' => 'contra_voucher',
                'account_id' => $request->credit_account_id,  //debit side and credit side shoud be same
                'main_amount' => $sub_amount,  //debit side and credit side shoud be same
                'narration' => $request->debit_account_narration[0],  //debit side and credit side shoud be same

                'sub_account_id' => $request->debit_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $request->debit_account_amount,
                'sub_narration' => $request->debit_account_narration,
                'is_approve' => (app('business_settings')->where('type', 'contra_voucher_approval')->first()->status == 1) ? 1 : 0,
                'is_transfer' => 1,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => ($request->cheque_date != null) ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
            ], $id);

            DB::commit();
            LogActivity::successLog('Transfer Info been updated Successfully.');
            Toastr::success(__('account.Transfer Info been updated Successfully'));

            return redirect()->route('transfer_showroom.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Voucher Payment update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
