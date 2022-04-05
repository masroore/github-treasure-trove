<?php

namespace Modules\Setup\Repositories;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Setup\Entities\ApplyLoan;

class ApplyLoanRepository implements ApplyLoanRepositoryInterface
{
    public function all()
    {
        return ApplyLoan::where('user_id', Auth::id())->orWhere('created_by', Auth::id())->latest()->get();
    }

    public function appliedAll()
    {
        return ApplyLoan::with('user', 'department')->latest()->get();
    }

    public function staffLoans($id)
    {
        return ApplyLoan::where('user_id', $id)->latest()->get();
    }

    public function create(array $data): void
    {
        $apply_loan = new ApplyLoan();
        $apply_loan->user_id = $data['user'];
        $apply_loan->department_id = $data['department_id'];
        $apply_loan->title = $data['title'];
        $apply_loan->loan_type = $data['loan_type'];
        $apply_loan->apply_date = Carbon::now()->toDateString();
        $apply_loan->loan_date = Carbon::parse($data['loan_date'])->format('Y-m-d');
        $apply_loan->amount = $data['amount'];
        $apply_loan->total_month = $data['total_month'];
        $apply_loan->monthly_installment = $data['monthly_installment'];
        $apply_loan->note = $data['note'];
        $apply_loan->save();
    }

    public function find($id)
    {
        return ApplyLoan::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $apply_loan = ApplyLoan::findOrFail($id);
        $apply_loan->user_id = Auth::user()->id;
        $apply_loan->department_id = $data['department_id'];
        $apply_loan->title = $data['title'];
        $apply_loan->loan_type = $data['loan_type'];
        $apply_loan->apply_date = Carbon::now()->toDateString();
        $apply_loan->loan_date = Carbon::parse($data['loan_date'])->format('Y-m-d');
        $apply_loan->amount = $data['amount'];
        $apply_loan->total_month = $data['total_month'];
        $apply_loan->monthly_installment = $data['monthly_installment'];
        $apply_loan->note = $data['note'];
        $apply_loan->save();
    }

    public function delete($id)
    {
        return ApplyLoan::findOrFail($id)->delete();
    }

    public function change_approval(array $data): void
    {
        $apply_loan = ApplyLoan::findOrFail($data['id']);
        $chart_account = ChartAccount::where('type', '1')->where('code', '01-01-02')->first();
        $apply_loan->approval = $data['approval'];

        if ($data['approval'] == 1) {
            $debit_account_id[] = ChartAccount::where('contactable_id', $apply_loan->user_id)->where('contactable_type', User::class)->first()->id;
            $debit_account_amount[] = $apply_loan->amount;
            $narration[] = 'Staff Loan';
            $repo = new VoucherRepository();
            $repo->create([
                'voucher_type' => 'CV',
                'amount' => $apply_loan->amount,
                'date' => Carbon::now()->format('Y-m-d'),
                'payment_type' => 'voucher_payment',
                'credit_account_id' => $chart_account->id,  //debit side and credit side shoud be same
                'credit_account_amount' => $apply_loan->amount,  //debit side and credit side shoud be same
                'credit_account_narration' => 'Advance & Loan Accounts',  //debit side and credit side shoud be same
                'debit_account_id' => $debit_account_id,   //debit side and credit side shoud be same
                'debit_account_amount' => $debit_account_amount,
                'debit_account_narration' => $narration,
                'narration' => 'Staff Loan',
                'cheque_no' => null,
                'cheque_date' => null,
                'bank_name' => null,
                'bank_branch' => null,
                'is_approve' => (app('business_settings')->where('type', 'loan_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
        }

        $apply_loan->save();
    }

    public function loanUser()
    {
        return User::with('role', 'staff')->whereHas('loans')->get();
    }
}
