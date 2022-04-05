<?php

namespace App\Http\Controllers;

use App\Models\BreadCrumb;
use App\Models\Repair;
use App\Models\ShipManage\ShipMaterialCategory;
use App\Models\ShipManage\ShipMaterialSubKind;
use App\Models\ShipManage\ShipRegister;
use App\Models\ShipMember\ShipPosition;
use Auth;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function register(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolder();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        $params = $request->all();

        $shipRegTbl = new ShipRegister();

        $shipName = '';
        if (isset($params['id'])) {
            $shipId = $params['id'];
        } else {
            if (count($shipList) > 0) {
                $shipId = $shipList[0]['IMO_No'];
            } else {
                $shipId = 0;
            }
        }

        $shipName = $shipRegTbl->getShipNameByIMO($shipId);

        if (isset($params['year'])) {
            $activeYear = $params['year'];
        } else {
            $activeYear = date('Y');
        }

        if (isset($params['month'])) {
            $activeMonth = $params['month'];
        } else {
            $activeMonth = date('m');
        }

        $tbl = new Repair();
        $yearList = $tbl->getYearList();
        // Department List from 设备清单
        $departList = ShipMaterialCategory::orderBy('order_no', 'asc')->get();
        // Charget List
        $posList = ShipPosition::all();
        // Type List from 设备清单
        $typeList = ShipMaterialSubKind::all();

        return view('repair.register', [
            'shipList' => $shipList,
            'shipId' => $shipId,
            'shipName' => $shipName,
            'years' => $yearList,
            'activeYear' => $activeYear,
            'activeMonth' => (int) $activeMonth,
            'departList' => $departList,
            'typeList' => $typeList,
            'chargeList' => $posList,

            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function update(Request $request)
    {
        $params = $request->all();

        $activeYear = $params['year'];
        $activeMonth = $params['month'];

        $tbl = new Repair();
        $ret = $tbl->udpateData($params);

        return redirect('/repair/register' . '?id=' . $params['ship_id'] . '&year=' . $activeYear . '&month=' . $activeMonth);
    }

    public function list(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        $params = $request->all();

        $shipRegTbl = new ShipRegister();

        $shipName = '';
        if (isset($params['id'])) {
            $shipId = $params['id'];
        } else {
            if (count($shipList) > 0) {
                $shipId = $shipList[0]['IMO_No'];
            } else {
                $shipId = 0;
            }
        }

        $shipName = $shipRegTbl->getShipNameByIMO($shipId);

        $yearList = [2021];

        if (isset($params['year'])) {
            $activeYear = $params['year'];
        } else {
            $activeYear = $yearList[0];
        }

        // Department List from 设备清单
        $departList = ShipMaterialCategory::orderBy('order_no', 'asc')->get();
        // Charget List
        $posList = ShipPosition::all();
        // Type List from 设备清单
        $typeList = ShipMaterialSubKind::orderBy('order_no', 'asc')->get();

        return view('repair.list', [
            'shipList' => $shipList,
            'shipId' => $shipId,
            'shipName' => $shipName,
            'years' => $yearList,
            'activeYear' => $activeYear,
            'activeMonth' => (int) (date('m')),
            'departList' => $departList,
            'typeList' => $typeList,
            'chargeList' => $posList,

            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function ajax_list(Request $request)
    {
        $params = $request->all();

        if (!isset($params['ship_id'])) {
            return false;
        }
        // $ship_id = $params['ship_id'];
        // $year = $params['year'];
        // $month = $params['month'];
        $tbl = new Repair();
        $list = $tbl->getList($params);

        return response()->json($list);
    }

    public function ajax_search(Request $request)
    {
        $params = $request->all();

        if (!isset($params['ship_id'])) {
            return false;
        }

        $tbl = new Repair();
        $list = $tbl->getSearch($params);

        return response()->json($list);
    }

    public function ajax_getReport(Request $request)
    {
        $params = $request->all();

        if (!isset($params['ship_id'])) {
            return false;
        }

        $tbl = new Repair();
        $list = $tbl->getReportList($params);

        return response()->json($list);
    }

    public function ajax_delete(Request $request)
    {
        $id = $request->get('id');

        $ret = repair::where('id', $id)->delete();

        return response()->json($ret);
    }
}
