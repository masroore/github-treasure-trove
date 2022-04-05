<?php

namespace Modules\Leave\Http\Controllers;

use App\Repositories\UserRepository;
use App\Traits\Notification;
use App\Traits\PdfGenerate;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Leave\Repositories\LeaveRepository;
use Modules\Leave\Repositories\LeaveTypeRepository;
use Modules\Setup\Repositories\DepartmentRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class LeaveController extends Controller
{
    use Notification;
    use PdfGenerate;

    private $leaveRepository;

    private $userRepository;

    private $deptRepo;

    private $leaveTypeRepository;

    public function __construct(LeaveRepository $leaveRepository, UserRepository $userRepository, DepartmentRepository $deptRepo, LeaveTypeRepository $leaveTypeRepository)
    {
        $this->leaveRepository = $leaveRepository;
        $this->userRepository = $userRepository;
        $this->deptRepo = $deptRepo;
        $this->leaveTypeRepository = $leaveTypeRepository;
    }

    public function index()
    {
        try {
            $apply_leaves = $this->leaveRepository->all();
            $apply_leave_histories = $this->leaveRepository->user_leave_history(Auth::id());
            $total_leave = $this->leaveRepository->totalLeave(Auth::id());
            $users = $this->userRepository->normalUser();

            return view('leave::apply_leaves.index', [
                'apply_leaves' => $apply_leaves,
                'apply_leave_histories' => $apply_leave_histories,
                'total_leave' => $total_leave,
                'users' => $users,
                'types' => $this->leaveTypeRepository->activeTypes(),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function create()
    {
        return view('leave::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'reason' => 'required|max:255',
            'attachment' => 'nullable|mimes:jpeg,jep,png,docx,txt,pdf',
            'apply_date' => 'required',
            'start_date' => 'required',
            'day' => 'required',
            'from_day' => 'required_if:day,==,0',
            'end_date' => 'required_if:day,==,2',
        ]);

        try {
            $user = $this->userRepository->findUser($request->user);
            if ($user->staff->leave_applicable_date <= Carbon::parse($request->start_date)->format('Y-m-d')) {
                $apply_leave = $this->leaveRepository->create($request->except('_token'));
                $role_id = null;
                $class = $apply_leave;
                $content = 'A Leave Has been Applied By ' . $apply_leave->user->name;
                $route = route('apply_leave.index');
                $ids = [];
                for ($i = 1; $i <= 2; ++$i) {
                    $this->sendNotification($class, app('general_setting')->email, 'Leave Reminder', $content, app('general_setting')->phone, $content, $i, $i, $route);
                    $ids[] = $i;
                }

                LogActivity::successLog('Leave Apply has been submitted.');

                return response()->json([
                    'success' => trans('leave.Leave Apply has been submitted Successfully'),
                    'table' => $this->table(),
                ]);
            }

            return response()->json([
                'error' => trans('leave.User is not Permitted for leave yet'),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Applying Leave');

            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    public function table()
    {
        $apply_leaves = $this->leaveRepository->all();

        return (string) view('leave::apply_leaves.table', compact('apply_leaves'));
    }

    public function show(Request $request)
    {
        try {
            $view = 0;
            $apply_leave = $this->leaveRepository->find($request->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history($request->user_id);
            $total_leave = $this->leaveRepository->total_leave($request->user_id);
            if ($request->view && $request->view == 1) {
                $view = 1;
            }

            return view('leave::apply_approvals.view', [
                'apply_leave' => $apply_leave,
                'apply_leave_histories' => $apply_leave_histories,
                'total_leave' => $total_leave,
                'view' => $view,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    public function edit(Request $request)
    {
        try {
            $apply_leave = $this->leaveRepository->find($request->id);

            return view('leave::apply_leaves.edit', [
                'apply_leave' => $apply_leave,
                'types' => $this->leaveTypeRepository->activeTypes(),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'reason' => 'required|max:255',
            'attachment' => 'nullable|mimes:jpeg,jep,png,docx,txt,pdf',
            'apply_date' => 'required',
            'start_date' => 'required',
            'day' => 'required',
            'from_day' => 'required_if:day,==,0',
            'end_date' => 'required_if:day,==,2',
        ]);

        try {
            $user = $this->userRepository->findUser($request->user);
            if ($user->staff->leave_applicable_date <= $request->start_date) {
                $apply_leave = $this->leaveRepository->update($request->except('_token'), $id);
                $role_id = null;
                $class = $apply_leave;
                $content = 'A Leave Has been Edited By ' . $apply_leave->updator->name;
                $route = route('apply_leave.index');
                for ($i = 1; $i <= 2; ++$i) {
                    $this->sendNotification($class, app('general_setting')->email, 'Leave Reminder', $content, app('general_setting')->phone, $content, $i, $i, $route);
                }

                LogActivity::successLog('Apply Leave Updated Successfully');

                return response()->json([
                    'success' => trans('Apply Leave Updated Successfully'),
                    'table' => $this->table(),
                ]);
            }

            return response()->json(trans('leave.User is not Permitted for leave yet'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->leaveRepository->delete($id);
            LogActivity::successLog('Apply Leave Deleted Successfully');
            Toastr::success('Apply Leave Deleted Successfully.');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something Went Wrong.');

            return back();
        }
    }

    public function approved_index()
    {
        $approved_leaves = $this->leaveRepository->approved_all();

        return view('leave::apply_approvals.approval_list', [
            'approved_leaves' => $approved_leaves,
        ]);
    }

    public function pending_index()
    {
        $pending_leaves = $this->leaveRepository->pending_all();

        return view('leave::apply_approvals.pending_list', [
            'pending_leaves' => $pending_leaves,
        ]);
    }

    public function change_approval(Request $request)
    {
        try {
            $leave = $this->leaveRepository->change_approval($request->except('_token'));

            $user_id = $leave->user_id;
            $role_id = null;
            $subject = $request->reason;
            $class = $leave;
            $content = 'A leave request has been made by ' . $leave->user->name . ' for being ' . $leave->reason . ' has been approved';
            $route = route('staffs.view', $leave->user->staff->id);

            $this->sendNotification($class, $leave->user->email, 'Leave Reminder', $subject, $leave->user->staff->phone, $content, $user_id, $leave->user->role_id, $route, 'Leave');

            LogActivity::successLog('Apply Leave status changed Successfully');

            return response()->json([
                'success' => trans('leave.Status has been updated Successfully'),
            ]);
        } catch (Exception $e) {
            return $e;
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function carryForward()
    {
        $users = $this->userRepository->user()->where('role_id', '!=', 1);

        return view('leave::apply_leaves.carry_forward', compact('users'));
    }

    public function generateCarryForward()
    {
        DB::beginTransaction();

        try {
            $this->leaveRepository->generate();
            DB::commit();
            Toastr::success(trans('leave.Carry Forward Generated Successfully'));

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function updateCarryForward(Request $request)
    {
        try {
            $this->leaveRepository->updateCarryForward($request->except('_token'));

            return trans('leave.Carry Forward Status Update');
        } catch (Exception $e) {
            return trans('common.Something Went Wrong');
        }
    }

    public function departmentWiseApprove()
    {
        try {
            $departments = $this->deptRepo->activeDept();

            return view('leave::apply_approvals.dept_wise_list', compact('departments'));
        } catch (Exception $e) {
            Toastr::error('common.Something Went Wrong');

            return back();
        }
    }

    public function departmentWiseSearch(Request $request)
    {
        try {
            $departments = $this->deptRepo->activeDept();
            $leaves = $this->leaveRepository->user_leave_history($request->user_id);
            $staffs = $this->userRepository->deptStaffs($request->department_id);
            $data = [
                'departments' => $departments,
                'leaves' => $leaves,
                'staffs' => $staffs,
                'dept_id' => $request->department_id,
                'user_id' => $request->user_id,
            ];

            return view('leave::apply_approvals.dept_wise_list')->with($data);
        } catch (Exception $e) {
            Toastr::error('common.Something Went Wrong');

            return back();
        }
    }

    //Ajax Request for get dept staffs
    public function staffs(Request $request)
    {
        try {
            $staffs = $this->userRepository->deptStaffs($request->department_id);
            if (count($staffs) > 0) {
                $output = '<option>' . trans('common.Select') . ' ' . trans('staff.Staff') . '</option>';
                foreach ($staffs as $user) {
                    $output .= '<option value="' . $user->id . '">' . $user->name . '</option>';
                }
            } else {
                $output = '<option>' . trans('common.No data Found') . '</option>';
            }

            return response()->json($output, 200);
        } catch (Exception $e) {
            return response()->json(trans('common.Something Went Wrong'), 500);
        }
    }

    public function downloadLeaveApplication($id)
    {
        try {
            $apply_leave = $this->leaveRepository->find($id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history($apply_leave->user_id);
            $total_leave = $this->leaveRepository->total_leave($apply_leave->user_id);
            $title = $apply_leave->reason . '-' . $apply_leave->start_date . '.pdf';
            $data = [
                'apply_leave' => $apply_leave,
                'apply_leave_histories' => $apply_leave_histories,
                'total_leave' => $total_leave,
            ];

            return $this->getPdf($title, 'leave::apply_leaves.pdf', $data);
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }
}
