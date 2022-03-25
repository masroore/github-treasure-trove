<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'employee_id',
        'branch_id',
        'department_id',
        'designation_id',
        'company_doj',
        'documents',
        'account_holder_name',
        'account_number',
        'bank_name',
        'bank_identifier_code',
        'branch_location',
        'tax_payer_id',
        'salary_type',
        'salary',
        'created_by',
    ];

    public function documents()
    {
        return $this->hasMany('App\Models\EmployeeDocument', 'employee_id', 'employee_id')->get();
    }

    public function salary_type()
    {
        return $this->hasOne('App\Models\PayslipType', 'id', 'salary_type')->pluck('name')->first();
    }

    public function get_net_salary()
    {

        //allowance
        $allowances = Allowance::where('employee_id', '=', $this->id)->get();
        $total_allowance = 0;
        foreach ($allowances as $allowance) {
            $total_allowance = $allowance->amount + $total_allowance;
        }

        //commission
        $commissions = Commission::where('employee_id', '=', $this->id)->get();
        $total_commission = 0;
        foreach ($commissions as $commission) {
            $total_commission = $commission->amount + $total_commission;
        }

        //Loan
        $loans = Loan::where('employee_id', '=', $this->id)->get();
        $total_loan = 0;
        foreach ($loans as $loan) {
            $total_loan = $loan->amount + $total_loan;
        }

        //Saturation Deduction
        $saturation_deductions = SaturationDeduction::where('employee_id', '=', $this->id)->get();
        $total_saturation_deduction = 0;
        foreach ($saturation_deductions as $saturation_deduction) {
            $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
        }

        //OtherPayment
        $other_payments = OtherPayment::where('employee_id', '=', $this->id)->get();
        $total_other_payment = 0;
        foreach ($other_payments as $other_payment) {
            $total_other_payment = $other_payment->amount + $total_other_payment;
        }

        //Overtime
        $over_times = Overtime::where('employee_id', '=', $this->id)->get();
        $total_over_time = 0;
        foreach ($over_times as $over_time) {
            $total_work = $over_time->number_of_days * $over_time->hours;
            $amount = $total_work * $over_time->rate;
            $total_over_time = $amount + $total_over_time;
        }

        //Net Salary Calculate
        $advance_salary = $total_allowance + $total_commission - $total_loan - $total_saturation_deduction + $total_other_payment + $total_over_time;

        $employee = self::where('id', '=', $this->id)->first();

        return (!empty($employee->salary) ? $employee->salary : 0) + $advance_salary;
    }

    public static function allowance($id)
    {

        //allowance
        $allowances = Allowance::where('employee_id', '=', $id)->get();
        $total_allowance = 0;
        foreach ($allowances as $allowance) {
            $total_allowance = $allowance->amount + $total_allowance;
        }

        return json_encode($allowances);
    }

    public static function commission($id)
    {
        //commission
        $commissions = Commission::where('employee_id', '=', $id)->get();
        $total_commission = 0;
        foreach ($commissions as $commission) {
            $total_commission = $commission->amount + $total_commission;
        }

        return json_encode($commissions);
    }

    public static function loan($id)
    {
        //Loan
        $loans = Loan::where('employee_id', '=', $id)->get();
        $total_loan = 0;
        foreach ($loans as $loan) {
            $total_loan = $loan->amount + $total_loan;
        }

        return json_encode($loans);
    }

    public static function saturation_deduction($id)
    {
        //Saturation Deduction
        $saturation_deductions = SaturationDeduction::where('employee_id', '=', $id)->get();
        $total_saturation_deduction = 0;
        foreach ($saturation_deductions as $saturation_deduction) {
            $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
        }

        return json_encode($saturation_deductions);
    }

    public static function other_payment($id)
    {
        //OtherPayment
        $other_payments = OtherPayment::where('employee_id', '=', $id)->get();
        $total_other_payment = 0;
        foreach ($other_payments as $other_payment) {
            $total_other_payment = $other_payment->amount + $total_other_payment;
        }

        return json_encode($other_payments);
    }

    public static function overtime($id)
    {
        //Overtime
        $over_times = Overtime::where('employee_id', '=', $id)->get();
        $total_over_time = 0;
        foreach ($over_times as $over_time) {
            $total_work = $over_time->number_of_days * $over_time->hours;
            $amount = $total_work * $over_time->rate;
            $total_over_time = $amount + $total_over_time;
        }

        return json_encode($over_times);
    }

    public static function employee_id()
    {
        $employee = self::latest()->first();

        return !empty($employee) ? $employee->id + 1 : 1;
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }

    public function designation()
    {
        return $this->hasOne('App\Models\Designation', 'id', 'designation_id');
    }

    public function salaryType()
    {
        return $this->hasOne('App\Models\PayslipType', 'id', 'salary_type');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function paySlip()
    {
        return $this->hasOne('App\Models\PaySlip', 'id', 'employee_id');
    }

    public function present_status($employee_id, $data)
    {
        return AttendanceEmployee::where('employee_id', $employee_id)->where('date', $data)->first();
    }

    public static function employee_name($name)
    {
        $employee = self::where('id', $name)->first();
        if (!empty($employee)) {
            return $employee->name;
        }
    }

    public static function login_user($name)
    {
        $user = User::where('id', $name)->first();

        return $user->name;
    }

    public static function employee_salary($salary)
    {
        $employee = self::where('salary', $salary)->first();
        if ('0' == $employee->salary || '0.0' == $employee->salary) {
            return '-';
        }

        return $employee->salary;
    }
}
