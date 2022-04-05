<?php

namespace Modules\Leave\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Leave\Repositories\LeaveTypeRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class LeaveTypeController extends Controller
{
    private $leaveTypeRepository;

    public function __construct(LeaveTypeRepository $leaveTypeRepository)
    {
        $this->leaveTypeRepository = $leaveTypeRepository;
    }

    public function index()
    {
        try {
            $data['LeaveTypeList'] = $this->leaveTypeRepository->all();

            return view('leave::leave_types.index', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:leave_types', 'max:255'],
            'status' => 'required',
        ]);

        try {
            $this->leaveTypeRepository->create($request->all());

            LogActivity::successLog(trans('leave.Leave Type Added Successfully'));

            return response()->json([
                'success' => trans('leave.Leave Type Added Successfully'),
                'TableData' => $this->loadTableData(),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:leave_types,name,' . $request->id],
            'status' => 'required',
        ]);

        try {
            $this->leaveTypeRepository->update($request->all(), $request->id);

            LogActivity::successLog(trans('leave.Leave Type updated Successfully'));

            return response()->json([
                'success' => trans('leave.Leave Type updated Successfully'),
                'TableData' => $this->loadTableData(),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $this->leaveTypeRepository->delete($request['id']);

            return response()->json([
                'success' => trans('leave.Leave Type Deleted Successfully'),
                'TableData' => $this->loadTableData(),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    private function loadTableData()
    {
        try {
            $LeaveTypeList = $this->leaveTypeRepository->all();

            return (string) view('leave::leave_types.components.list', compact('LeaveTypeList'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }
}
