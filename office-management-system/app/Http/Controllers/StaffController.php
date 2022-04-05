<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Repositories\UserRepositoryInterface;
use App\StaffDocument;
use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Leave\Repositories\LeaveRepository;
use Modules\Payroll\Repositories\PayrollRepositoryInterface;
use Modules\RolePermission\Entities\Role;
use Modules\Setup\Repositories\ApplyLoanRepositoryInterface;

class StaffController extends Controller
{
    use Notification;

    protected $userRepository;

    protected $leaveRepository;

    protected $payrollRepository;

    protected $applyLoanRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LeaveRepository $leaveRepository,
        PayrollRepositoryInterface $payrollRepository,
        ApplyLoanRepositoryInterface $applyLoanRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware('prohibited.demo.mode')->only(['update', 'profile_update']);

        $this->userRepository = $userRepository;
        $this->leaveRepository = $leaveRepository;
        $this->payrollRepository = $payrollRepository;
        $this->applyLoanRepository = $applyLoanRepository;
    }

    public function index(Request $request)
    {
        try {
            $staffs = $this->userRepository->all(['user']);

            return view('backEnd.staffs.index', [
                'staffs' => $staffs,
            ]);
        } catch (Exception $e) {
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function create()
    {
        return view('backEnd.staffs.create');
    }

    public function store(StaffRequest $request)
    {
        DB::beginTransaction();

        try {
            if ($request->password) {
                try {
                    $staff = $this->userRepository->store($request->except('_token'));
                    $created_by = Auth::user()->name;
                    $company = app('general_setting')->company_name;
                    $content = 'You have been added as a Staff by ' . $created_by . ' for ' . $company . ' ';
                    if ($staff && $staff->phone) {
                        $number = $staff->phone;
                        $message = 'Congrats ! You have been added as a Staff by ' . $created_by . 'for ' . $company . ' ';
                        $this->sendNotification($staff, $staff->user->email, 'Staff Added', $content, $number, $message, $staff->user->id);
                    }
                    DB::commit();
                    LogActivity::successLog(__('common.Staff has been added Successfully'));
                    Toastr::success(__('common.Staff has been added Successfully'));

                    return redirect()->route('staffs.index');
                } catch (Exception $e) {
                    DB::rollBack();
                    LogActivity::errorLog($e->getMessage());
                    Toastr::error(__('common.Something Went Wrong'));

                    return back();
                }
            } else {
                DB::rollBack();
                Toastr::error(__('common.Something Went Wrong'));

                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show(Request $request)
    {
        try {
            $staffDetails = $this->userRepository->find($request->id);
            $leaveDetails = $this->leaveRepository->user_leave_history($staffDetails->user->id);
            $total_leave = $this->leaveRepository->total_leave($staffDetails->user->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history($staffDetails->user->id);
            $payrollDetails = $this->payrollRepository->userPayrollDetails($request->id);
            $staffDocuments = $this->userRepository->findDocument($request->id);
            $loans = $this->applyLoanRepository->staffLoans($staffDetails->user->id);

            return view('backEnd.staffs.viewStaff', [
                'staffDetails' => $staffDetails,
                'leaveDetails' => $leaveDetails,
                'total_leave' => $total_leave,
                'staffDocuments' => $staffDocuments,
                'payrollDetails' => $payrollDetails,
                'apply_leave_histories' => $apply_leave_histories,
                'loans' => $loans,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function report_print(Request $request)
    {
        try {
            $staffDetails = $this->userRepository->find($request->id);

            return view('backEnd.staffs.print_view', [
                'staffDetails' => $staffDetails,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit($id)
    {
        try {
            $staff = $this->userRepository->find($id);
            $roles = Role::where('type', $staff->user->role->type)->get();

            return view('backEnd.staffs.edit', [
                'staff' => $staff,
                'roles' => $roles,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(StaffUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $staff = $this->userRepository->update($request->except('_token'), $id);

            $created_by = \Illuminate\Support\Facades\Auth::user()->name;
            $company = app('general_setting')->company_name;
            $content = 'Your info has been updated as a Staff by ' . $created_by . ' for ' . $company . ' ';
            $number = $staff->phone;
            $message = 'Your info Have Been updated by ' . $created_by . ' as a Staff for ' . $company . ' ';
            $this->sendNotification($staff, $staff->user->email, 'Staff Added', $content, $number, $message);

            DB::commit();
            LogActivity::successLog($request->username . '- profile has been updated.');
            Toastr::success(__('common.Staff info has been updated Successfully'));

            return redirect()->route('staffs.index');
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $staff = $this->userRepository->delete($id);
            LogActivity::successLog('Staff has been destroyed.');
            Toastr::success(__('common.Staff has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Staff has been detected for Role Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function status_update(Request $request)
    {
        try {
            $staff = $this->userRepository->statusUpdate($request->except('_token'));
            LogActivity::successLog('User Active Status has been updated.');

            return response()->json([
                'success' => trans('leave.Status has been updated Successfully'),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function document_store(Request $request)
    {
        try {
            if ($request->file('file') != '' && $request->name != '') {
                $file = $request->file('file');
                $document = 'staff-' . md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/staff/document/', $document);
                $document = 'uploads/staff/document/' . $document;
                $staffDocument = new StaffDocument();
                $staffDocument->name = $request->name;
                $staffDocument->staff_id = $request->staff_id;
                $staffDocument->documents = $document;
                $staffDocument->save();
            }
            Toastr::success(__('common.Staff Document has been uploaded Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function document_destroy($id)
    {
        try {
            $staff = $this->userRepository->deleteStaffDoc($id);
            LogActivity::successLog('Document of Staff has been destroyed.');
            Toastr::success(__('common.Staff Document has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - detected for Staff Document Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function profile_view()
    {
        try {
            $staffDetails = $this->userRepository->find(Auth::user()->staff->id);
            $leaveDetails = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $total_leave = $this->leaveRepository->total_leave(Auth::user()->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $payrollDetails = $this->payrollRepository->userPayrollDetails(Auth::user()->staff->id);
            $staffDocuments = $this->userRepository->findDocument(Auth::user()->staff->id);
            $loans = $this->applyLoanRepository->staffLoans(Auth::user()->id);

            return view('backEnd.profiles.profile', [
                'staffDetails' => $staffDetails,
                'leaveDetails' => $leaveDetails,
                'total_leave' => $total_leave,
                'staffDocuments' => $staffDocuments,
                'payrollDetails' => $payrollDetails,
                'apply_leave_histories' => $apply_leave_histories,
                'loans' => $loans,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return back();
        }
    }

    public function profile_edit(Request $request)
    {
        try {
            $user = $this->userRepository->findUser($request->id);

            return view('backEnd.profiles.editProfile', [
                'user' => $user,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return back();
        }
    }

    public function profile_update(Request $request, $id)
    {
        /*if (env('APP_SYNC')) {
            Toastr::error('Restricted in demo mode');
            return back();
        }*/
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . Auth::id(),
            'phone' => 'sometimes|nullable|unique:staffs,phone,' . Auth::user()->staff->id,
            'password' => 'sometimes|nullable|confirmed',
            'password_confirmation' => 'required_with:password,',
        ]);
        if (Auth::user()->role_id != 1) {
            $request->validate([
                'bank_name' => 'required',
                'bank_branch_name' => 'required',
                'bank_account_name' => 'required',
                'bank_account_no' => 'required',
                'current_address' => 'required',
                'permanent_address' => 'required',
            ]);
        }

        try {
            $this->userRepository->updateProfile($request->except('_token'), $id);
            LogActivity::successLog('Profile has been updated.');
            Toastr::success(__('common.Staff info has been updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function csv_upload()
    {
        return view('backEnd.staffs.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->userRepository->csv_upload_staff($request->except('_token'));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            } else {
                Toastr::error('Something went wrong. Upload again !!!');
            }

            return back();
        }
    }
}
