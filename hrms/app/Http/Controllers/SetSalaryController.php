<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\AllowanceOption;
use App\Models\Commission;
use App\Models\DeductionOption;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanOption;
use App\Models\OtherPayment;
use App\Models\Overtime;
use App\Models\PayslipType;
use App\Models\SaturationDeduction;
use Auth;
use Illuminate\Http\Request;
use Validator;

class SetSalaryController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Set Salary')) {
            $employees = Employee::where(
                [
                    'created_by' => Auth::user()->creatorId(),
                ]
            )->get();

            return view('setsalary.index', compact('employees'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit($id)
    {
        if (Auth::user()->can('Edit Set Salary')) {
            $payslip_type = PayslipType::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $allowance_options = AllowanceOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $loan_options = LoanOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $deduction_options = DeductionOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            if ('employee' == Auth::user()->type) {
                $currentEmployee = Employee::where('user_id', '=', Auth::user()->id)->first();
                $allowances = Allowance::where('employee_id', $currentEmployee->id)->get();
                $commissions = Commission::where('employee_id', $currentEmployee->id)->get();
                $loans = Loan::where('employee_id', $currentEmployee->id)->get();
                $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
                $otherpayments = OtherPayment::where('employee_id', $currentEmployee->id)->get();
                $overtimes = Overtime::where('employee_id', $currentEmployee->id)->get();
                $employee = Employee::where('user_id', '=', Auth::user()->id)->first();

                return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
            }

            $allowances = Allowance::where('employee_id', $id)->get();
            $commissions = Commission::where('employee_id', $id)->get();
            $loans = Loan::where('employee_id', $id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
            $otherpayments = OtherPayment::where('employee_id', $id)->get();
            $overtimes = Overtime::where('employee_id', $id)->get();
            $employee = Employee::find($id);

            return view('setsalary.edit', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show($id)
    {
        $payslip_type = PayslipType::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        $allowance_options = AllowanceOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        $loan_options = LoanOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        $deduction_options = DeductionOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        if ('employee' == Auth::user()->type) {
            $currentEmployee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $allowances = Allowance::where('employee_id', $currentEmployee->id)->get();
            $commissions = Commission::where('employee_id', $currentEmployee->id)->get();
            $loans = Loan::where('employee_id', $currentEmployee->id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
            $otherpayments = OtherPayment::where('employee_id', $currentEmployee->id)->get();
            $overtimes = Overtime::where('employee_id', $currentEmployee->id)->get();
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();

            return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
        }

        $allowances = Allowance::where('employee_id', $id)->get();
        $commissions = Commission::where('employee_id', $id)->get();
        $loans = Loan::where('employee_id', $id)->get();
        $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
        $otherpayments = OtherPayment::where('employee_id', $id)->get();
        $overtimes = Overtime::where('employee_id', $id)->get();
        $employee = Employee::find($id);

        return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
    }

    public function employeeUpdateSalary(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'salary_type' => 'required',
                'salary' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $employee = Employee::findOrFail($id);
        $input = $request->all();
        $employee->fill($input)->save();

        return redirect()->back()->with('success', 'Employee Salary Updated.');
    }

    public function employeeSalary()
    {
        if ('employee' == Auth::user()->type) {
            $employees = Employee::where('user_id', Auth::user()->id)->get();

            return view('setsalary.index', compact('employees'));
        }
    }

    public function employeeBasicSalary($id)
    {
        $payslip_type = PayslipType::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        $employee = Employee::find($id);

        return view('setsalary.basic_salary', compact('employee', 'payslip_type'));
    }
}
