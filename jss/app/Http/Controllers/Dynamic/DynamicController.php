<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/13
 * Time: 9:39.
 */

namespace App\Http\Controllers\Dynamic;

use App\Http\Controllers\Controller;
use App\Models\Member\Unit;
use App\Models\ShipManage\ShipRegister;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DynamicController extends Controller
{
    protected $userinfo;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxGetDynamicData(Request $request)
    {
        $params = $request->all();
        $type = $params['type'];
        if ($type == 'nationality') {
            $result = DB::table('tb_dynamic_nationality')->select('*')->get();

            return response()->json($result);
        } elseif ($type == 'rank') {
            $result = DB::table('tb_ship_duty')->select('*')->orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();

            return response()->json($result);
        } elseif ($type == 'capacity') {
            $result = DB::table('tb_member_capacity')->select('*')->orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();

            return response()->json($result);
        } elseif ($type == 'shiptype') {
            $result = DB::table('tb_ship_type')->select('*')->orderBy('orderNo')->get();

            return response()->json($result);
        } elseif ($type == 'port') {
            $result = DB::table('tbl_port')->select('*')->orderBy('Port_En')->get();

            return response()->json($result);
        } elseif ($type == 'pos') {
            $result = DB::table('tb_pos')->select('*')->orderByRaw('CAST(orderNum AS SIGNED) ASC')->get();

            return response()->json($result);
        }

        return response()->json('fail');
    }

    public function ajaxSetDynamicData(Request $request)
    {
        $params = $request->all();
        $type = $params['type'];

        if ($type == 'nationality') {
            $list = $params['list'];
            $default = $params['default'];

            $result = DB::table('tb_dynamic_nationality')->truncate();
            $i = 0;
            foreach ($list as $item) {
                if ($item != '') {
                    if ($i == $default) {
                        DB::table('tb_dynamic_nationality')->insert(['name' => $item, 'isDefault' => '1']);
                    } else {
                        DB::table('tb_dynamic_nationality')->insert(['name' => $item]);
                    }
                    ++$i;
                }
            }
        } elseif ($type == 'shiptype') {
            $ids = $params['ids'];
            $orderno = $params['orderno'];
            $name = $params['name'];

            $result = DB::table('tb_ship_type')->truncate();
            for ($i = 0; $i < count($orderno); ++$i) {
                if ($ids[$i] != '') {
                    DB::table('tb_ship_type')->insert(['id' => $ids[$i], 'OrderNo' => $orderno[$i], 'ShipType' => $name[$i]]);
                } elseif ($name[$i] != '') {
                    DB::table('tb_ship_type')->insert(['OrderNo' => $orderno[$i], 'ShipType' => $name[$i]]);
                }
            }
            $new_records = DB::table('tb_ship_type')->select('id', 'ShipType', 'OrderNo')->orderBy('OrderNo')->get();

            return response()->json($new_records);
        } elseif ($type == 'rank') {
            $ids = $params['id'];
            $orderno = $params['orderno'];
            $name = $params['name'];
            $abb = $params['abb'];
            $description = $params['description'];

            $result = DB::table('tb_ship_duty')->truncate();
            //DB::table('tb_ship_duty')->whereNotIn('id', $ids)->delete();
            for ($i = 0; $i < count($orderno); ++$i) {
                if ($ids[$i] != '') {
                    //DB::table('tb_ship_duty')->where('id', $ids[$i])->update(['OrderNo' => $orderno[$i], 'Abb' => $abb[$i], 'Duty_En' => $name[$i], 'Description' => $description[$i]]);
                    DB::table('tb_ship_duty')->insert(['id' => $ids[$i], 'OrderNo' => $orderno[$i], 'Abb' => $abb[$i], 'Duty_En' => $name[$i], 'Description' => $description[$i]]);
                } elseif (/*$orderno[$i] != '' || */ $abb[$i] != '' || $name[$i] != '' || $description[$i] != '') {
                    DB::table('tb_ship_duty')->insert(['OrderNo' => $orderno[$i], 'Abb' => $abb[$i], 'Duty_En' => $name[$i], 'Description' => $description[$i]]);
                }
            }
            $new_records = DB::table('tb_ship_duty')->select('id', 'Duty_En', 'OrderNo', 'Abb')->orderBy('OrderNo')->get();

            return response()->json($new_records);
        } elseif ($type == 'capacity') {
            $ids = $params['ids'];
            $orderno = $params['orderno'];
            $name = $params['name'];
            $stcw = $params['STCW'];
            $description = $params['description'];

            $result = DB::table('tb_member_capacity')->truncate();
            for ($i = 0; $i < count($name); ++$i) {
                if ($ids[$i] != '') {
                    DB::table('tb_member_capacity')->insert(['id' => $ids[$i], 'OrderNo' => $orderno[$i], 'Capacity_En' => $name[$i], 'STCWRegID' => $stcw[$i], 'Remarks' => $description[$i]]);
                } elseif ($stcw[$i] != '' || $name[$i] != '' || $description[$i] != '') {
                    DB::table('tb_member_capacity')->insert(['OrderNo' => $orderno[$i], 'Capacity_En' => $name[$i], 'STCWRegID' => $stcw[$i], 'Remarks' => $description[$i]]);
                }
            }
            $new_records = DB::table('tb_member_capacity')->select('id', 'OrderNo', 'Capacity_En')->orderBy('OrderNo')->get();

            return response()->json($new_records);
        } elseif ($type == 'port') {
            $Port_En = $params['port_en'];
            $Port_Cn = $params['port_cn'];

            $result = DB::table('tbl_port')->truncate();
            for ($i = 0; $i < count($Port_En); ++$i) {
                if ($Port_En[$i] != '' || $Port_Cn[$i] != '') {
                    DB::table('tbl_port')->insert(['Port_En' => $Port_En[$i], 'Port_Cn' => $Port_Cn[$i]]);
                }
            }
        } elseif ($type == 'pos') {
            $ids = $params['id'];
            $Pos_OrderNum = $params['orderno'];
            $Pos_Title = $params['name'];

            //$result = DB::table('tbl_port')->truncate();
            DB::table('tb_pos')->whereNotIn('id', $ids)->delete();
            for ($i = 0; $i < count($Pos_OrderNum); ++$i) {
                if ($Pos_Title[$i] != '') {
                    if ($ids[$i] == '') {
                        DB::table('tb_pos')->insert(['orderNum' => $Pos_OrderNum[$i], 'title' => $Pos_Title[$i]]);
                    } else {
                        DB::table('tb_pos')->where('id', $ids[$i])->update(['orderNum' => $Pos_OrderNum[$i], 'title' => $Pos_Title[$i]]);
                    }
                }
            }
        } else {
            return response()->json('-1');
        }

        return response()->json('0');
    }

    public function ajaxSetNationality(Request $request): void
    {
        $params = $request->all();
    }

    public function ajaxGetRank(Request $request): void
    {
    }

    public function ajaxSetRank(Request $request): void
    {
    }

    public function ajaxReportDetail(Request $request)
    {
        $params = $request->all();
        $userid = Auth::user()->id;
        $userRole = Auth::user()->isAdmin;

        Session::forget('reportFiles');
        //		if($userRole != SUPER_ADMIN)
        //			return response()->json('-1');

        $decideTbl = new DecisionReport();
        $retVal = $decideTbl->getReportDetail($params);

        return response()->json($retVal);
    }

    public function ajaxReportData(Request $request)
    {
        $params = $request->all();

        $shipList = ShipRegister::getShipListByOrigin();

        if (isset($params['shipId'])) {
            $shipRegNo = ShipRegister::find($params['shipId'])['RegNo'];
            $voyList = VoyLog::where('ship_ID', $shipRegNo)->get();
        } else {
            $voyList = [];
        }

        return response()->json(['shipList' => $shipList, 'voyList' => $voyList]);
    }

    public function ajaxProfitList(Request $request)
    {
        $params = $request->all();

        if (isset($params['profitType'])) {
            $profitType = $params['profitType'];
        } else {
            $profitType = 0;
        }

        $profitList = ACItem::where('C_D', $profitType)->orderBy('id')->get();

        return response()->json($profitList);
    }

    public function ajaxReportFile(Request $request)
    {
        $params = $request->all();

        $hasFile = $request->file('file');
        if (isset($hasFile)) {
            if (isset($hasFile)) {
                $name = date('Ymd_H_i_s') . '.' . $hasFile->getClientOriginalExtension();
                $hasFile->move(public_path() . '/files/', $name);
                $fileList[] = [$hasFile->getClientOriginalName(), '/files/' . $name];

                if (Session::get('reportFiles')) {
                    $reportFile = Session::get('reportFiles');
                } else {
                    $reportFile = [];
                }
                $reportFile[] = $fileList;
                Session::put('reportFiles', $reportFile);
            }
        }

        $retVal = Session::get('reportFiles');

        $retVal[][] = ['请选择文件。', '请选择文件。'];

        return response()->json($retVal);
    }

    public function ajaxGetDepartment()
    {
        $retVal = Unit::where('parentId', '!=', 0)->get();

        return response()->json($retVal);
    }

    public function ajaxCheckShipType(Request $request)
    {
        $params = $request->all();
        $shiptype = $params['type'];
        $retVal = true;
        if (isset($shiptype) && ($shiptype != null)) {
            $result = ShipRegister::where('ShipType', $shiptype)->get();
            if (!$result->isEmpty()) {
                $retVal = false;
            }
        }

        return response()->json($retVal);
    }

    public function ajaxCheckRankType(Request $request)
    {
        $params = $request->all();
        $ranktype = $params['rank'];
        $retVal = true;
        if (isset($ranktype) && ($ranktype != null)) {
            $result = DB::table('tb_ship_member')->where('DutyID_Book', $ranktype)->select('id', 'GivenName')->get();
            if (!$result->isEmpty()) {
                $retVal = false;
            }
        }

        return response()->json($retVal);
    }

    public function ajaxCheckCapacity(Request $request)
    {
        $params = $request->all();
        $capacity = $params['capacity'];
        $retVal = true;
        if (isset($capacity) && ($capacity != null)) {
            $result = DB::table('tb_capacity_registry')->where('CapacityID', $capacity)->orWhere('COEId', $capacity)->select('id')->get();
            if (!$result->isEmpty()) {
                $retVal = false;
            }
        }

        return response()->json($retVal);
    }

    public function ajaxCheckAccount(Request $request)
    {
        $params = $request->all();
        $account = $params['account'];
        $retVal = true;
        if (isset($account) && ($account != null)) {
            $result = DB::table('tb_water_list')->where('account_type', $account)->select('id')->get();
            if (!$result->isEmpty()) {
                $retVal = false;
            }
        }

        return response()->json($retVal);
    }
}
