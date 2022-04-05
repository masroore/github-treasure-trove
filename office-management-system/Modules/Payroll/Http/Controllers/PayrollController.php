<?php

namespace Modules\Payroll\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Traits\Notification;
use App\Traits\PdfGenerate;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Payroll\Http\Requests\PayrollFilterFormRequest;
use Modules\Payroll\Http\Requests\PayrollReportFormRequest;
use Modules\Payroll\Repositories\PayrollRepositoryInterface;
use Modules\Setup\Entities\ApplyLoan;

class PayrollController extends Controller
{
    use Notification;
    use PdfGenerate;

    protected $payrollRepository;

    protected $userRepository;

    public function __construct(PayrollRepositoryInterface $payrollRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->payrollRepository = $payrollRepository;
    }

    public function index()
    {
        try {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            return view('payroll::payrolls.index', compact('months'));
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for payroll');

            return redirect()->back();
        }
    }

    public function create()
    {
        return view('payroll::create');
    }

    public function show($id)
    {
        return view('payroll::show');
    }

    public function edit($id)
    {
        return view('payroll::edit');
    }

    public function search_for_payroll(PayrollFilterFormRequest $request)
    {
        try {
            $users = $this->payrollRepository->user($request->all());
            $r = $request->role_id;
            $m = $request->month;
            $y = $request->year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            return view('payroll::payrolls.index', [
                'users' => $users,
                'r' => $r,
                'm' => $m,
                'y' => $y,
                'months' => $months,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for payroll');

            return redirect()->back();
        }
    }

    public function generatePayroll(Request $request, $id, $payroll_month, $payroll_year)
    {
        try {
            $staffDetails = $this->payrollRepository->userFind($id);
            $month = date('m', strtotime($payroll_month));
            $attendances = $this->payrollRepository->attendance($id, $payroll_month, $payroll_year);

            $p = 0;
            $l = 0;
            $a = 0;
            $f = 0;
            $h = 0;
            foreach ($attendances as $value) {
                if ($value->attendance == 'P') {
                    ++$p;
                } elseif ($value->attendance == 'L') {
                    ++$l;
                } elseif ($value->attendance == 'A') {
                    ++$a;
                } elseif ($value->attendance == 'F') {
                    ++$f;
                } elseif ($value->attendance == 'H') {
                    ++$h;
                }
            }
            $loans = ApplyLoan::Nonpaid()->where('user_id', $id)->get();
            $approve_leaves = $this->payrollRepository->leaveApprove($id);

            return view('payroll::payrolls.generatePayroll', compact('staffDetails', 'payroll_month', 'payroll_year', 'p', 'l', 'a', 'f', 'h', 'loans'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function savePayrollData(Request $request, UserRepositoryInterface $userRepository)
    {
        $request->validate([
            'net_salary' => 'required',
        ]);
        DB::beginTransaction();

        try {
            $this->payrollRepository->create($request->except('_token'));
            $staff = $userRepository->find($request->staff_id);
            LogActivity::successLog('Payroll Generated for - ' . $staff->employee_id);
            DB::commit();
            Toastr::success('Operation successful', 'Success');

            return redirect()->route('payroll.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function paymentPayroll(Request $request)
    {
        try {
            $payrollDetails = $this->payrollRepository->find($request->id);
            $role_id = $request->role_id;

            return view('payroll::payrolls.paymentPayroll', compact('payrollDetails', 'role_id'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function savePayrollPaymentData(Request $request)
    {
        DB::beginTransaction();

        try {
            $payroll = $this->payrollRepository->savePayrollPaymentData($request->except('_token'));

            $created_by = Auth::user()->name;
            $content = 'Salary Has been generated by ' . $created_by . '.Your Net Salary was: ' . $payroll->net_salary . '';
            $number = $payroll->staff->phone;
            $message = 'Salary Has been generated by ' . $created_by . '. Your Net Salary was: ' . $payroll->net_salary . '';
            $this->sendNotification($payroll, $payroll->staff->user->email, 'Salary Generate Reminder', $content, $number, $message, $payroll->staff->user_id, null, null);

            LogActivity::successLog('Payroll Payment paid for - ' . $payroll->staff->employee_id);
            DB::commit();
            Toastr::success('Payment Has been done Successfully');

            return redirect()->route('payroll.index');
        } catch (Exception $e) {
            DB::rollBack();

            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function viewPayslip(Request $request)
    {
        try {
            $payrollDetails = $this->payrollRepository->find($request->id);
            $payrollEarnDetails = $this->payrollRepository->payrollEarnDetails($request->id);
            $payrollDedcDetails = $this->payrollRepository->payrollDedcDetails($request->id);

            return view('payroll::payrolls.viewPayslip', compact('payrollDetails', 'payrollEarnDetails', 'payrollDedcDetails'));
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function report_index()
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('payroll::payroll_reports.payroll', compact('months'));
    }

    public function searchPayrollReport(PayrollReportFormRequest $request)
    {
        try {
            $r = $request->role_id;
            $m = $request->month;
            $y = $request->year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $payrolls = $this->payrollRepository->payrollReports($request->role_id, $request->month, $request->year);

            return view('payroll::payroll_reports.payroll', compact('months', 'm', 'y', 'r', 'payrolls'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');

            return redirect()->back();
        }
    }

    public function getPdf($id)
    {
        try {
            $payrollDetails = $this->payrollRepository->find($id);

            return $this->getPayroll('payroll::payrolls.viewPayslip', $payrollDetails);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
