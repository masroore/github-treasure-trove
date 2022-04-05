<?php

namespace Modules\Leave\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Leave\Repositories\LeaveDefineRepository;
use Modules\Leave\Repositories\LeaveTypeRepository;
use Modules\RolePermission\Repositories\RoleRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class LeaveDefineController extends Controller
{
    private $leaveDefineRepository;

    private $roleRepo;

    private $leaveTypeRpo;

    public function __construct(LeaveDefineRepository $leaveDefineRepository, RoleRepository $roleRepo, LeaveTypeRepository $leaveTypeRpo)
    {
        $this->leaveDefineRepository = $leaveDefineRepository;
        $this->roleRepo = $roleRepo;
        $this->leaveTypeRpo = $leaveTypeRpo;
    }

    public function index()
    {
        try {
            $data['LeaveDefineList'] = $this->leaveDefineRepository->all();
            $data['RoleList'] = $this->roleRepo->regularRoles();
            $data['LeaveTypeList'] = $this->leaveTypeRpo->all();

            return view('leave::leave_defines.index', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required',
                'leave_type_id' => 'required',
                'total_days' => 'required',
                'max_forward' => 'required_if:balance_forward,==,1',
            ],
            [
                'max_forward.required_if' => 'The max forward field is required when balance forward is checked.',
            ]
        );

        try {
            DB::beginTransaction();
            $defined = $this->leaveDefineRepository->roleWiseLeave($request->leave_type_id, $request->role_id);
            $request['adjust_days'] = $defined ? $defined->total_days : 0;

            if ($defined && empty($request->users)) {
                return response()->json(trans('leave.Leave Type For this role already defined'));
            }

            $this->leaveDefineRepository->create($request->all());
            $LeaveDefineList = $this->leaveDefineRepository->all();
            DB::commit();
            LogActivity::successLog('Leave Define added Successfully');

            return response()->json([
                'success' => trans('leave.Leave Defined Successfully'),
                'TableData' => (string) view('leave::leave_defines.components.list', compact('LeaveDefineList')),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());

            return response()->json(trans('common.Something Went Wrong'));
        }
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required',
                'leave_type_id' => 'required',
                'total_days' => 'required',
                'max_forward' => 'required_if:balance_forward,==,1',
            ],
            [
                'max_forward.required_if' => 'The max forward field is required when balance forward is checked.',
            ]
        );
        DB::beginTransaction();

        try {
            $this->leaveDefineRepository->update($request->all(), $request->id);

            $LeaveDefineList = $this->leaveDefineRepository->all();
            DB::commit();
            LogActivity::successLog('Leave Define updated Successfully');

            return response()->json([
                'success' => trans('leave.Leave Define Updated Successfully'),
                'TableData' => (string) view('leave::leave_defines.components.list', compact('LeaveDefineList')),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());

            return response()->json(trans('common.Something Went Wrong'));
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $this->leaveDefineRepository->delete($request->id);
            $LeaveDefineList = $this->leaveDefineRepository->all();

            return response()->json([
                'success' => trans('leave.Leave Define Deleted Successfully'),
                'TableData' => (string) view('leave::leave_defines.components.list', compact('LeaveDefineList')),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(trans('common.Something Went Wrong'));
        }
    }
}
