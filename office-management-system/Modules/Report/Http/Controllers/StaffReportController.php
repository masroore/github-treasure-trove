<?php

namespace Modules\Report\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepository;
use Modules\Report\Repositories\StaffReportRepository;
use Modules\Setup\Repositories\DepartmentRepositoryInterface;

class StaffReportController extends Controller
{
    protected $userRepository;

    protected $showRoomRepository;

    protected $staffReportRepository;

    protected $departmentRepository;

    protected $warehouseRepository;

    protected $charAccountRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        StaffReportRepository $staffReportRepository,
        DepartmentRepositoryInterface $departmentRepository,
        WareHouseRepository $warehouseRepository,
        ChartAccountRepositoryInterface $charAccountRepository
    ) {
        $this->userRepository = $userRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->staffReportRepository = $staffReportRepository;
        $this->departmentRepository = $departmentRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->charAccountRepository = $charAccountRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $showrooms = $this->showRoomRepository->all();
            $department = $this->departmentRepository->all();
            $warehouses = $this->warehouseRepository->all();

            $showroom_id = $request->showRoom_id ?? null;
            $department_id = $request->department_id ?? null;
            $warehouse_id = $request->warehouse_id ?? null;

            $staffs = $this->staffReportRepository->search($showroom_id, $department_id, $warehouse_id);

            return view('report::staff_report.index', [
                'staffs' => $staffs,
                'showrooms' => $showrooms,
                'departments' => $department,
                'department_id' => $department_id,
                'showroom_id' => $showroom_id,
                'warehouses' => $warehouses,
                'warehouse_id' => $warehouse_id,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function showHistory(Request $request, $id)
    {
        try {
            $staff = $this->userRepository->find($id);
            $chartAccountId = $this->charAccountRepository->getFirst('App\User', $id);

            if ($staff->user->role_id == 1 || $chartAccountId == null) {
                return back();
            }

            $currentBalance = 0 + $staff->opening_balance;
            foreach ($chartAccountId->transactions as $key => $payment) {
                $payment->type == 'Dr' ? $currentBalance += $payment->amount : $currentBalance -= $payment->amount;
            }
            $account_id = $id;
            if ($request->has('print')) {
                $chartAccount = ChartAccount::where('contactable_type', 'App\User')->where('contactable_id', $account_id)->first();

                return view('report::staff_report.print_view', compact('staff', 'account_id', 'currentBalance', 'chartAccount'));
            }

            return view('report::staff_report.history', compact('staff', 'account_id', 'currentBalance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
