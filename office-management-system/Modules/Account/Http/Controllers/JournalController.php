<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Http\Requests\JournalFormRequest;
use Modules\Account\Repositories\JournalRepositoryInterface;
use Toastr;

class JournalController extends Controller
{
    protected $journalRepository;

    public function __construct(JournalRepositoryInterface $journalRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->journalRepository = $journalRepository;
    }

    public function index()
    {
        $journals = $this->journalRepository->journal_all();

        return view('account::journal_vouchers.index', [
            'journals' => $journals,
        ]);
    }

    public function create()
    {
        $accounts = $this->journalRepository->transactionalAccounts();

        return view('account::journal_vouchers.create', [
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
                $this->journalRepository->create([
                    'voucher_type' => 'JV',
                    'amount' => $request->main_amount,
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'account_type' => $request->account_type,
                    'payment_type' => 'journal_voucher',
                    'account_id' => $request->account_id,
                    'main_amount' => $request->main_amount,
                    'narration' => $request->narration,

                    'sub_account_id' => $request->sub_account_id,
                    'sub_amount' => $request->sub_amount,
                    'sub_narration' => $request->sub_narration,
                    'is_approve' => (app('business_settings')->where('type', 'journal_voucher_approval')->first()->status == 1) ? 1 : 0,
                ]);
                DB::commit();
                LogActivity::successLog('Journal has been Added.');
                Toastr::success(__('account.Journal has been added Successfully'));

                return redirect()->route('journal.index');
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
        $journal = $this->journalRepository->find($id);
        $accounts = $this->journalRepository->all();

        return view('account::journal_vouchers.edit', [
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
                $this->journalRepository->update([
                    'voucher_type' => 'JV',
                    'amount' => $request->main_amount,
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'account_type' => $request->account_type,
                    'payment_type' => 'journal_voucher',
                    'account_id' => $request->account_id,
                    'main_amount' => $request->main_amount,
                    'narration' => $request->narration,

                    'sub_account_id' => $request->sub_account_id,
                    'sub_amount' => $request->sub_amount,
                    'sub_narration' => $request->sub_narration,
                    'is_approve' => (app('business_settings')->where('type', 'journal_voucher_approval')->first()->status == 1) ? 1 : 0,
                ], $id);
                DB::commit();
                LogActivity::successLog('Journal has been updated.');
                Toastr::success(__('account.Journal has been updated Successfully'));

                return redirect()->route('journal.index');
            } catch (Exception $e) {
                DB::rollBack();
                LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Journal update');
                Toastr::error(__('common.Something Went Wrong'));

                return back();
            }
        } else {
            Toastr::error(__('account.Debit and Credit amount was mismatched.'));

            return back();
        }
    }
}
