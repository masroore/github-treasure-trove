<?php

namespace Modules\Payroll\Repositories;

use App\Staff;
use App\User;
use Carbon\Carbon;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\JournalRepository;
use Modules\Account\Repositories\JournalRepositoryInterface;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Attendance\Entities\Attendance;
use Modules\Leave\Entities\ApplyLeave;
use Modules\Payroll\Entities\Payroll;
use Modules\Payroll\Entities\PayrollEarnDeduce;
use Modules\Setup\Entities\ApplyLoan;

class PayrollRepository implements PayrollRepositoryInterface
{
    protected $journalRepository;

    protected $voucherRepository;

    public function __construct(JournalRepositoryInterface $journalRepository, VoucherRepository $voucherRepository)
    {
        $this->journalRepository = $journalRepository;
        $this->voucherRepository = $voucherRepository;
    }

    public function create(array $data): void
    {
        $payrollGenerate = new Payroll();
        $payrollGenerate->staff_id = $data['staff_id'];
        $payrollGenerate->role_id = $data['role_id'];
        $payrollGenerate->payroll_month = $data['payroll_month'];
        $payrollGenerate->payroll_year = $data['payroll_year'];
        $payrollGenerate->basic_salary = $data['basic_salary'];
        $payrollGenerate->total_earning = $data['total_earnings'];
        $payrollGenerate->total_deduction = $data['total_deduction'];
        $payrollGenerate->gross_salary = $data['final_gross_salary'];
        $payrollGenerate->tax = $data['tax'];
        $payrollGenerate->net_salary = $data['net_salary'];
        $payrollGenerate->payroll_status = 'G';
        $result = $payrollGenerate->save();
        $payrollGenerate->toArray();
        if (!empty($data['loan_id']) && !empty($data['loanStatus'])) {
            foreach ($data['loan_id'] as $key => $loan_id) {
                $loan = ApplyLoan::findOrFail($loan_id);
                if ($loan->amount > $loan->paid_loan_amount) {
                    $loan->paid_loan_amount += $data['deductionsValue'][$key];
                    if ($loan->amount == $loan->paid_loan_amount) {
                        $loan->paid = 1;
                        $loan->save();
                    } else {
                        $loan->save();
                    }
                }
            }
        }
        if ($result) {
            $earnings = count($data['earningsType']);
            for ($i = 0; $i < $earnings; ++$i) {
                if (!empty($data['earningsType'][$i]) && !empty($data['earningsValue'][$i])) {
                    $payroll_earn_deducs = new PayrollEarnDeduce();
                    $payroll_earn_deducs->payroll_id = $payrollGenerate->id;
                    $payroll_earn_deducs->type_name = $data['earningsType'][$i];
                    $payroll_earn_deducs->amount = $data['earningsValue'][$i];
                    $payroll_earn_deducs->earn_dedc_type = 'E';
                    $result = $payroll_earn_deducs->save();
                }
            }
            if ($data['deductionsValue'][0] != null) {
                $deductions = count($data['deductionstype']);
                for ($i = 0; $i < $deductions; ++$i) {
                    if (!empty($data['deductionstype'][$i]) && !empty($data['deductionsValue'][$i])) {
                        $payroll_earn_deducs = new PayrollEarnDeduce();
                        $payroll_earn_deducs->payroll_id = $payrollGenerate->id;
                        $payroll_earn_deducs->type_name = $data['deductionstype'][$i];
                        $payroll_earn_deducs->amount = $data['deductionsValue'][$i];
                        $payroll_earn_deducs->earn_dedc_type = 'D';
                        if (!empty($data['loanStatus']) && array_key_exists($i, $data['loanStatus'])) {
                            $payroll_earn_deducs->loan_status = 1;
                        }
                        $result = $payroll_earn_deducs->save();
                    }
                }
            }
        }
    }

    public function find($id)
    {
        return Payroll::find($id);
    }

    public function userFind($id)
    {
        return User::find($id);
    }

    public function attendance($id, $payroll_month, $payroll_year)
    {
        return Attendance::where('user_id', $id)->where('month', $payroll_month)->where('year', $payroll_year)->get();
    }

    public function leaveApprove($id)
    {
        return ApplyLeave::where('status', 1)->where('user_id', $id)->get();
    }

    public function user(array $data)
    {
        return User::with('staff.department', 'loans')->where('role_id', $data['role_id'])->get();
    }

    public function savePayrollPaymentData(array $data)
    {
        $payments = Payroll::find($data['payroll_generate_id']);
        $payments->payment_date = Carbon::parse($data['payment_date'])->format('Y-m-d');
        $payments->payment_mode = $data['payment_mode'];
        $payments->note = $data['note'];

        if (array_key_exists('bank_name', $data)) {
            $payments->bank_name = $data['bank_name'];
            $payments->bank_branch_name = $data['bank_branch_name'];
            $payments->account_no = $data['account_no'];
        }

        if (array_key_exists('cheque_no', $data)) {
            $payments->cheque_no = $data['cheque_no'];
        }

        $payments->payroll_status = 'P';
        $result = $payments->update();
        $main_amount = $payments->basic_salary;
        $user = Staff::findOrFail($payments->staff_id)->user;

        $repo = new JournalRepository();

        if (count($payments->payroll_earn_deducs) > 0) {
            $debit_account_id[] = ChartAccount::where('code', '01-01-02')->first()->id; //Cash Account
            $debit_account_amount[] = $payments->net_salary;
            $narration[] = 'Salary Pay';

            foreach ($payments->payroll_earn_deducs as $earn_deduc) {
                if ($earn_deduc->loan_status == 1 && $earn_deduc->earn_dedc_type == 'D') {
                    $debit_account_id[] = ChartAccount::where('contactable_id', $user->id)->where('contactable_type', get_class(new User()))->first()->id;
                    $debit_account_amount[] = $earn_deduc->amount;
                    $narration[] = $earn_deduc->name;
                } elseif ($earn_deduc->earn_dedc_type == 'D') {
                    $main_amount -= $earn_deduc->amount;
                } elseif ($earn_deduc->earn_dedc_type == 'E') {
                    $main_amount += $earn_deduc->amount;
                }
            }
            $repo->create([
                'voucher_type' => 'JV',
                'amount' => $main_amount,
                'date' => Carbon::now()->format('Y-m-d'),
                'account_type' => 'debit',
                'payment_type' => 'journal_voucher',
                'account_id' => ChartAccount::where('code', '03-18')->first()->id,  //Salary & Allowance
                'main_amount' => $main_amount,  //debit side and credit side shoud be same
                'narration' => 'Staff Salary',  //debit side and credit side shoud be same

                'sub_account_id' => $debit_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $debit_account_amount,
                'sub_narration' => $narration,
                'is_approve' => (app('business_settings')->where('type', 'payroll_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
        } else {
            $debit_account_id[] = ChartAccount::where('code', '03-18')->first()->id; //Salary & Allowance
            $debit_account_amount[] = $payments->net_salary;
            $narration[] = 'Salary Pay';
            $chart_account = ChartAccount::where('code', '01-01-02')->first()->id; //Cash Account

            $repo->create([
                'voucher_type' => 'JV',
                'amount' => $payments->basic_salary,
                'date' => Carbon::now()->format('Y-m-d'),
                'account_type' => 'credit',
                'payment_type' => 'journal_voucher',
                'account_id' => $chart_account,  //here will be changed
                'main_amount' => $payments->basic_salary,  //debit side and credit side shoud be same
                'narration' => 'Staff Salary',  //debit side and credit side shoud be same

                'sub_account_id' => $debit_account_id,   //debit side and credit side shoud be same
                'sub_amount' => $debit_account_amount,
                'sub_narration' => $narration,
                'is_approve' => (app('business_settings')->where('type', 'payroll_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
        }

        return $payments;
    }

    public function payrollEarnDetails($id)
    {
        return PayrollEarnDeduce::where('active_status', '=', '1')->where('payroll_id', '=', $id)->where('earn_dedc_type', '=', 'E')->get();
    }

    public function payrollDedcDetails($id)
    {
        return PayrollEarnDeduce::where('active_status', '=', '1')->where('payroll_id', '=', $id)->where('earn_dedc_type', '=', 'D')->get();
    }

    public function payrollReports($role, $month, $year)
    {
        return Payroll::where('payroll_month', $month)->where('payroll_year', $year)->where('role_id', $role)->latest()->get();
    }

    public function userPayrollDetails($id)
    {
        return Payroll::where('staff_id', $id)->latest()->get();
    }
}
