<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;

use App\Models\BreadCrumb;

use App\Models\Decision\DecisionReport;
use App\Models\ShipManage\ShipRegister;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('operation/operationPlan');
    }

    public function incomeExpense(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $start_year = DecisionReport::select(DB::raw('MIN(report_date) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2020-01-01';
        } else {
            $start_year = substr($start_year['min_date'], 0, 4);
        }
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        return view('operation.incomeExpense', [
            'start_year' => $start_year,
            'shipList' => $shipList,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function incomeAllExpense(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $start_year = DecisionReport::select(DB::raw('MIN(report_date) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2020-01-01';
        } else {
            $start_year = substr($start_year['min_date'], 0, 4);
        }
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        return view('operation.incomeAllExpense', [
            'start_year' => $start_year,
            'shipList' => $shipList,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function ajaxIncomeExportListByShipForPast(Request $request)
    {
        $params = $request->all();
        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getIncomeExportListForPast($params);

        return response()->json($reportList);
    }

    public function ajaxIncomeExportListByShip(Request $request)
    {
        $params = $request->all();
        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getIncomeExportList($params);

        return response()->json($reportList);
    }

    public function ajaxListBySOA(Request $request)
    {
        $params = $request->all();
        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getListBySOA($params);

        return response()->json($reportList);
    }

    public function ajaxListByAll(Request $request)
    {
        $params = $request->all();
        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getListByAll($params);

        return response()->json($reportList);
    }
}
