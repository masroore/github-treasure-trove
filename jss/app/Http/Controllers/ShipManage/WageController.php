<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/13
 * Time: 9:39.
 */

namespace App\Http\Controllers\ShipManage;

use App\Http\Controllers\Controller;
use App\Models\BreadCrumb;
use App\Models\Finance\AccountSetting;
use App\Models\ShipManage\ShipRegister;

use App\Models\ShipMember\ShipMember;
use App\Models\ShipMember\ShipPosition;
use App\Models\ShipMember\ShipWage;

use App\Models\ShipMember\ShipWageList;
use App\Models\ShipMember\ShipWageSend;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class WageController extends Controller
{
    protected $userInfo;

    private $control = 'shipManage';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function initWageCalcInfo(Request $request)
    {
        $params = $request->all();
        $shipId = $params['shipId'];
        $year = $params['year'];
        $month = $params['month'];

        ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 0)->delete();
        ShipWage::where('shipId', $shipId)->where('year', $year)->where('month', $month)->delete();

        return 1;
    }

    public function initWageSendInfo(Request $request)
    {
        $params = $request->all();
        $shipId = $params['shipId'];
        $year = $params['year'];
        $month = $params['month'];

        ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 1)->delete();
        ShipWageSend::where('shipId', $shipId)->where('year', $year)->where('month', $month)->delete();

        return 1;
    }

    public function updateWageSendInfo(Request $request)
    {
        $shipId = $request->get('select-ship');
        $year = $request->get('select-year');
        $month = $request->get('select-month');

        $array_purch_date = $request->get('PurchDate');
        $array_remark = $request->get('Remark');
        $array_memberId = $request->get('MemberId');
        $array_name = $request->get('Names');

        $array_R = $request->get('CashR');
        $array_D = $request->get('SendR');
        $array_P = $request->get('SendD');

        $array_send_bank = $request->get('SendBank');
        $array_rank = $request->get('Rank');
        $array_bankinfo = $request->get('BankInfo');

        $wage_list_record = ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 1)->first();
        if (null === $wage_list_record) {
            $wage_list_record = new ShipWageList();
        }
        $wage_list_record['year'] = $year;
        $wage_list_record['month'] = $month;
        $wage_list_record['shipId'] = $shipId;
        $wage_list_record['type'] = 1;
        $wage_list_record->save();

        ShipWageSend::where('shipId', $shipId)->where('year', $year)->where('month', $month)->delete();
        foreach ($array_R as $index => $item) {
            $wage_record = new ShipWageSend();

            $wage_record['shipId'] = $shipId;
            $wage_record['member_id'] = $array_memberId[$index];
            $wage_record['name'] = $array_name[$index];
            $wage_record['cashR'] = str_replace(',', '', $array_R[$index]);
            $wage_record['sendR'] = str_replace(',', '', $array_D[$index]);
            $wage_record['sendD'] = str_replace(',', '', $array_P[$index]);
            $wage_record['sendbank'] = str_replace(',', '', $array_send_bank[$index]);
            $wage_record['rank'] = $array_rank[$index];
            if ($array_purch_date[$index] == '') {
                $wage_record['purchdate'] = null;
            } else {
                $wage_record['purchdate'] = $array_purch_date[$index];
            }

            $wage_record['bankinfo'] = $array_bankinfo[$index];
            $wage_record['year'] = $year;
            $wage_record['month'] = $month;
            $wage_record['remark'] = $array_remark[$index];
            $wage_record->save();
        }

        return redirect('shipMember/wagesSend?shipId=' . $shipId . '&year=' . $year . '&month=' . $month);
    }

    public function updateWageCalcInfo(Request $request)
    {
        $shipId = $request->get('select-ship');
        $year = $request->get('select-year');
        $month = $request->get('select-month');
        $rate = $request->get('rate');
        $minus_days = $request->get('minus-days');

        $array_minus_cash = $request->get('MinusCash');
        $array_trans_date = $request->get('TransDate');
        $array_remark = $request->get('Remark');
        $array_memberId = $request->get('MemberId');
        $array_name = $request->get('Names');

        $array_R = $request->get('TransInR');
        $array_D = $request->get('TransInD');
        $array_transdate = $request->get('TransDate');

        $array_rank = $request->get('Rank');
        $array_wageCurrency = $request->get('Currency');
        $array_salary = $request->get('Salary');
        $array_dateonboard = $request->get('DateOnboard');
        $array_dateoffboard = $request->get('DateOffboard');
        $array_signdays = $request->get('SignDays');
        $array_bankinfo = $request->get('BankInfo');
        $report_date = $request->get('report_date');

        $wage_list_record = ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 0)->first();
        if (null === $wage_list_record) {
            $wage_list_record = new ShipWageList();
        }
        $wage_list_record['year'] = $year;
        $wage_list_record['month'] = $month;
        $wage_list_record['rate'] = $rate;
        $wage_list_record['minus_days'] = $minus_days;
        $wage_list_record['shipId'] = $shipId;
        $wage_list_record['report_date'] = $report_date;
        $wage_list_record['type'] = 0;
        $wage_list_record->save();

        ShipWage::where('shipId', $shipId)->where('year', $year)->where('month', $month)->delete();
        foreach ($array_minus_cash as $index => $item) {
            /*$wage_record = ShipWage::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('member_id',$array_memberId[$index])->first();
            if (is_null($wage_record)) {
                $wage_record = new ShipWage();
            }*/
            $wage_record = new ShipWage();

            $wage_record['shipId'] = $shipId;
            $wage_record['member_id'] = $array_memberId[$index];
            $wage_record['name'] = $array_name[$index];
            $wage_record['minuscash'] = str_replace(',', '', $array_minus_cash[$index]);
            $wage_record['cashR'] = str_replace(',', '', $array_R[$index]);
            $wage_record['cashD'] = str_replace(',', '', $array_D[$index]);
            $wage_record['rank'] = $array_rank[$index];
            $wage_record['currency'] = $array_wageCurrency[$index];
            $wage_record['salary'] = str_replace(',', '', $array_salary[$index]);
            $wage_record['signdays'] = $array_signdays[$index];
            if ($array_trans_date[$index] == '') {
                $wage_record['purchdate'] = null;
            } else {
                $wage_record['purchdate'] = $array_trans_date[$index];
            }

            if ($array_dateonboard[$index] == '') {
                $wage_record['signondate'] = null;
            } else {
                $wage_record['signondate'] = $array_dateonboard[$index];
            }

            if ($array_dateoffboard[$index] == '') {
                $wage_record['signoffdate'] = null;
            } else {
                $wage_record['signoffdate'] = $array_dateoffboard[$index];
            }

            $wage_record['bankinfo'] = $array_bankinfo[$index];
            $wage_record['year'] = $year;
            $wage_record['month'] = $month;
            $wage_record['remark'] = $array_remark[$index];
            $wage_record->save();
        }

        return redirect('shipMember/wagesCalc?shipId=' . $shipId . '&year=' . $year . '&month=' . $month);
    }

    public function index_report(Request $request)
    {
        return $this->index($request, 1);
    }

    public function send_report(Request $request)
    {
        return $this->send($request, 1);
    }

    public function index(Request $request, $type = 0)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $shipId = $request->get('shipId');
        $year = $request->get('year');
        $month = $request->get('month');
        $posList = ShipPosition::all();
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->select('tb_ship_register.IMO_No', 'tb_ship_register.shipName_En', 'tb_ship_register.NickName', 'tb_ship.name')
                ->whereIn('IMO_No', $ids)
                ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
                ->get();
        } else {
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->select('tb_ship_register.IMO_No', 'tb_ship_register.shipName_En', 'tb_ship_register.NickName', 'tb_ship.name')
                ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
                ->get();
        }
        $start_year = ShipMember::select(DB::raw('MIN(DateOnboard) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2020-01-01';
        } else {
            $start_year = $start_year['min_date'];
        }
        $start_month = date('m', strtotime($start_year));
        $start_year = date('Y', strtotime($start_year));
        if ($type == 1) {
            $user_pos = STAFF_LEVEL_SHAREHOLDER;
        }

        return view('shipMember.member_calc_wages', [
            'shipList' => $shipList,
            'posList' => $posList,
            'shipId' => $shipId,
            'year' => $year,
            'month' => $month,
            'start_year' => $start_year,
            'start_month' => $start_month,
            'user_pos' => $user_pos,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function send(Request $request, $type = 0)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $shipId = $request->get('shipId');
        $year = $request->get('year');
        $month = $request->get('month');
        $posList = ShipPosition::all();
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->select('tb_ship_register.IMO_No', 'tb_ship_register.shipName_En', 'tb_ship_register.NickName', 'tb_ship.name')
                ->whereIn('IMO_No', $ids)
                ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
                ->get();
        } else {
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->select('tb_ship_register.IMO_No', 'tb_ship_register.shipName_En', 'tb_ship_register.NickName', 'tb_ship.name')
                ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
                ->get();
        }
        $start_year = ShipMember::select(DB::raw('MIN(DateOnboard) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2020-01-01';
        } else {
            $start_year = $start_year['min_date'];
        }
        $start_month = date('m', strtotime($start_year));
        $start_year = date('Y', strtotime($start_year));
        $accounts = AccountSetting::select('*')->get();
        if ($type == 1) {
            $user_pos = STAFF_LEVEL_SHAREHOLDER;
        }

        return view('shipMember.member_send_wages', [
            'shipList' => $shipList,
            'posList' => $posList,
            'accounts' => $accounts,
            'shipId' => $shipId,
            'year' => $year,
            'month' => $month,
            'start_year' => $start_year,
            'start_month' => $start_month,
            'user_pos' => $user_pos,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function wagelist(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $shipId = $request->get('shipId');
        $year = $request->get('year');
        $month = $request->get('month');
        $posList = ShipPosition::all();
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }
        $start_year = ShipMember::select(DB::raw('MIN(DateOnboard) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2020-01-01';
        } else {
            $start_year = $start_year['min_date'];
        }
        $start_month = date('m', strtotime($start_year));
        $start_year = date('Y', strtotime($start_year));

        return view('shipMember.member_wages_list', [
            'shipList' => $shipList,
            'posList' => $posList,
            'shipId' => $shipId,
            'year' => $year,
            'month' => $month,
            'start_year' => $start_year,
            'start_month' => $start_month,
            'breadCrumb' => $breadCrumb,
        ]);
    }
}
