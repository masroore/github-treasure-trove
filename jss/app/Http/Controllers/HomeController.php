<?php

namespace App\Http\Controllers;

use App\Models\Decision\DecisionReport;
use App\Models\Home;
use App\Models\Home\Settings;
use App\Models\Home\SettingsSites;
use App\Models\Operations\CP;
use App\Models\Operations\VoyLog;
use App\Models\ShipManage\ShipCertList;
use App\Models\ShipManage\ShipCertRegistry;
use App\Models\ShipManage\ShipEquipmentRequire;
use App\Models\ShipManage\ShipRegister;
use App\Models\ShipMember\SecurityCert;
use App\Models\ShipMember\ShipMember;
use App\Models\ShipTechnique\ShipPort;
use App\Models\User;
use App\Models\UserInfo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $pos = Auth::user()->pos;
        $tbl = new User();
        $redirectTo = $tbl->getRedirectByRole($pos);
        if ($redirectTo != 'home') {
            return redirect($redirectTo);
        }

        $reportList = DecisionReport::where('state', '=', REPORT_STATUS_REQUEST)->get();
        foreach ($reportList as $key => $item) {
            $reportList[$key]->realname = UserInfo::find($item->creator)['realname'];
        }
        $shipList = ShipRegister::orderBy('id')->get();
        $shipForDecision = [];
        foreach ($shipList as $key => $item) {
            $shipForDecision[$item->IMO_No] = $item->shipName_En;
        }

        $expired_certData['ship'] = [];
        $expired_certData['member'] = [];

        $shipCertTbl = new ShipCertRegistry();
        $memberCertTbl = new ShipMember();

        $expired_certData['ship'] = $shipCertTbl->getExpiredList();

        foreach ($expired_certData['ship'] as $key => $item) {
            $expired_certData['ship'][$key]->ship_name = ShipRegister::where('IMO_No', $item->ship_id)->first()->shipName_En;
            $expired_certData['ship'][$key]->cert_name = ShipCertList::where('id', $item->cert_id)->first()->name;
        }

        /////////////////////////////////////////////
        $settings = Settings::where('id', 1)->first();
        $reportList = DecisionReport::where('state', '0')->where('ishide', 0)->get();
        $noattachments = DecisionReport::where(function ($query): void {
            $query->where('attachment', 0)->orWhere('attachment', null);
        })->where('ishide', 0)->get();

        //return $noattachments;

        $report_year = $settings['report_year'];
        $now = date('Y-m-d', strtotime("$report_year-1-1"));
        $next = date('Y-m-d', strtotime("$report_year-12-31"));

        $reportSummary = DecisionReport::where('report_date', '>=', $now)->where('report_date', '<=', $next)->groupBy('depart_id')->selectRaw('tb_unit.title,tb_decision_report.depart_id,count(depart_id) as count, count(depart_id)/(select count(depart_id) from tb_decision_report where report_date >= "' . $now . '" and report_date <= "' . $next . '")*100 as percent')
            ->groupBy('depart_id')
            ->leftJoin('tb_unit', 'tb_unit.id', '=', 'tb_decision_report.depart_id')
            ->get();
        $reportSummary = $reportSummary->sortByDesc('count');
        //return $reportSummary;
        $voyList = [];
        $index = 0;
        foreach ($shipList as $ship) {
            $record = VoyLog::where('Ship_ID', $ship['IMO_No'])->orderBy('id', 'desc')->first();
            if (!empty($record)) {
                $voyList[] = $record;
            }
        }
        $sites = SettingsSites::select('*')->orderByRaw('CAST(orderNo AS SIGNED INTEGER) ASC')->get();

        $shipEquip = new ShipEquipmentRequire();
        $equipment = $shipEquip->getDataForDash();

        $tbl = new ShipCertRegistry();
        $expireCert = $tbl->getExpiredList($settings->cert_expire_date);

        $tbl = new ShipMember();
        $expireMemberCert = $tbl->getExpiredList($settings->cert_expire_date);
        $voyNo_from = substr($settings['port_year'], 2, 2) . '00';
        $voyNo_to = substr($settings['report_year'], 2, 2) + 1;
        $voyNo_to = $voyNo_to . '00';

        $topPorts = CP::where('Voy_No', '>=', $voyNo_from)->where('Voy_No', '<', $voyNo_to)
            ->select(DB::raw("group_concat(LPort SEPARATOR ', ') as LPort, group_concat(DPort SEPARATOR ', ') as DPort"))
            ->get();
        $topPorts = array_count_values(preg_split('@,@', str_replace(' ', '', $topPorts[0]['LPort'] . ',' . $topPorts[0]['DPort']), null, PREG_SPLIT_NO_EMPTY));
        arsort($topPorts);
        $topPorts = array_slice($topPorts, 0, 10, true);
        $ports = [];
        $index = 0;
        foreach ($topPorts as $key => $count) {
            $port_name = ShipPort::where('id', $key)->select('Port_En', 'Port_Cn')->first();
            $ports[$index]['name'] = $port_name->Port_En . ' (' . $port_name->Port_Cn . ')';
            $ports[$index]['count'] = $count;
            ++$index;
        }
        $securityType = SecurityCert::all();

        return view('home.front', [
            'shipList' => $shipList,
            'reportList' => $reportList,
            'shipForDecision' => $shipForDecision,
            'expired_data' => $expired_certData,
            'settings' => $settings,
            'reportList' => $reportList,
            'noattachments' => $noattachments,
            'voyList' => $voyList,
            'sites' => $sites,
            'reportSummary' => $reportSummary,
            'equipment' => $equipment,
            'expireCert' => $expireCert,
            'expireMemberCert' => $expireMemberCert,
            'topPorts' => $ports,
            'security' => $securityType,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $old_passwd = $request->get('old_passwd');
        $new_passwd = $request->get('password');
        $confirm_passwd = $request->get('password_confirmation');

        $state = Session::get('state');
        $msg = Session::get('msg');

        if (empty($new_passwd)) {
            return view('auth.reset', ['state' => $state, 'msg' => $msg]);
        }

        if ($new_passwd != $confirm_passwd) {
            $msg = '两次输入的密码不一致。';

            return back()->with(['state' => 'error', 'msg' => $msg]);
        }

        $user = Auth::user();
        $password = $user->password;

        if (password_verify($old_passwd, $password)) {
            $user['password'] = Hash::make($new_passwd);
            $user->save();

            return redirect('/home');
        }
        $msg = '密码错误，请重新输入密码。';

        return back()->with(['state' => 'error', 'msg' => $msg]);
    }
}
