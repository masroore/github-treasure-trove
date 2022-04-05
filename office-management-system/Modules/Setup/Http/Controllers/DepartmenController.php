<?php

namespace Modules\Setup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Repositories\DepartmentRepositoryInterface;

class DepartmenController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        try {
            $data['DepartmentList'] = $this->departmentRepository->all();

            return view('setup::department.index', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:departments', 'max:255'],
            'details' => 'nullable|string|',
            'status' => 'required',
        ]);

        try {
            $createdItem = $this->departmentRepository->create([
                'name' => $request->name,
                'status' => $request->status,
                'details' => $request->details,
            ]);
            LogActivity::successLog($request->name . ' - Department created');

            return $this->loadTableData();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:departments,name,' . $request->id],
            'details' => 'nullable|string|max:1024',
        ]);

        try {
            $createdItem = $this->departmentRepository->update([
                'name' => $request->name,
                'status' => $request->status,
                'details' => $request->details,
            ], $request->id);
            LogActivity::successLog($request->name . ' - Department Updated');

            return $this->loadTableData();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $this->departmentRepository->delete($request['id']);

            return $this->loadTableData();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    private function loadTableData()
    {
        try {
            $DepartmentList = $this->departmentRepository->all();

            return response()->json([
                'TableData' => (string) view('setup::department.components.list', compact('DepartmentList')),
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
