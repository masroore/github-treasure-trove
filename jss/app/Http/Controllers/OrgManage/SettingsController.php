<?php

namespace App\Http\Controllers\Orgmanage;

use App\Http\Controllers\Controller;
use App\Models\BreadCrumb;
use App\Models\Decision\DecisionReport;
use App\Models\Home\Settings;
use App\Models\Home\SettingsSites;
use App\Models\Operations\VoyLog;
use App\Models\ShipManage\ShipRegister;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $shipList = ShipRegister::select('tb_ship_register.IMO_No', 'tb_ship_register.shipName_En', 'tb_ship_register.NickName', 'tb_ship.name')
            ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
            ->get();

        $settings = Settings::where('id', 1)->first();
        $reportList = DecisionReport::where('state', '0')->get();
        //$noattachments = DecisionReport::where('attachment',0)->orWhere('attachment',null)->get();
        $voyList = [];
        $index = 0;
        foreach ($shipList as $ship) {
            $record = VoyLog::where('Ship_ID', $ship['IMO_No'])->orderBy('id', 'desc')->first();
            if (!empty($record)) {
                $voyList[] = $record;
            }
        }
        $sites = SettingsSites::select('*')->whereNotNull('orderNo')->orderByRaw('CAST(orderNo AS SIGNED INTEGER) ASC')->get();

        $start_year = DecisionReport::select(DB::raw('MIN(report_date) as min_date'))->first();
        if (empty($start_year)) {
            $start_year = '2021-01-01';
        } else {
            $start_year = $start_year['min_date'];
        }
        $start_year = date('Y', strtotime($start_year));

        return view('orgmanage.settings', [
            'title' => '',
            'settings' => $settings,
            'shipList' => $shipList,
            'reportList' => $reportList,
            //'noattachments' => $noattachments,
            'voyList' => $voyList,
            'sites' => $sites,
            'start_year' => $start_year,

            'breadCrumb' => $breadCrumb,
        ]);
    }
}
