<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/13
 * Time: 9:39.
 */

namespace App\Http\Controllers\Decision;

use App\Http\Controllers\Controller;

use App\Models\BreadCrumb;
use App\Models\Common;
use App\Models\Decision\DecisionReport;
use App\Models\Decision\DecisionReportAttachment;

use App\Models\Finance\AccountPersonalInfo;
use App\Models\Finance\ReportSave;
use App\Models\Finance\WaterList;
use App\Models\Member\Unit;
use App\Models\Operations\AcItem;
use App\Models\Operations\CP;
use App\Models\ShipManage\ShipRegister;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DecisionController extends Controller
{
    protected $userinfo;

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Report List
    public function receivedReport(Request $request)
    {
        $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        $params = $request->all();

        $id = -1;
        if (isset($params['id'])) {
            $id = $params['id'];
        }

        $tbl = new DecisionReport();
        $yearList = $tbl->getYearList($id);
        $lastId = $tbl->getLastId();

        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        return view('decision.received_report', [
            'draftId' => $id,
            'shipList' => $shipList,
            'years' => $yearList,

            'lastId' => $lastId,

            'breadCrumb' => $breadCrumb,
        ]);
    }

    // Draft List
    public function draftReport(Request $request)
    {
        $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        $params = $request->all();

        $id = -1;
        if (isset($params['id'])) {
            $id = $params['id'];
        }

        $tbl = new DecisionReport();
        $yearList = $tbl->getYearList($id);

        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        return view('decision.draft_report', [
            'draftId' => $id,
            'shipList' => $shipList,
            'years' => $yearList,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function analyzeReport(Request $request)
    {
        $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        $params = $request->all();

        $id = -1;
        if (isset($params['id'])) {
            $id = $params['id'];
        }

        $tbl = new DecisionReport();
        $yearList = $tbl->getYearList($id);
        $lastId = $tbl->getLastId();

        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        return view('decision.analyze_report', [
            'draftId' => $id,
            'shipList' => $shipList,
            'years' => $yearList,

            'lastId' => $lastId,

            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function redirect(Request $request)
    {
        $params = $request->all();

        $draftId = $params['id'];

        return redirect('decision/receivedReport?id=' . $draftId);
    }

    // Added by Uzmaki
    public function reportSubmit(Request $request)
    {
        $params = $request->all();

        $reportId = $params['reportId'];
        if (isset($reportId) && $reportId != '') {
            $reportTbl = DecisionReport::find($reportId);
        } else {
            $reportTbl = new DecisionReport();
        }

        $draftId = $params['draftId'];

        $user = Auth::user();
        $commonTbl = new Common();
        if ($params['reportType'] != REPORT_STATUS_DRAFT) {
            if ((!isset($reportId) || $reportId == '') || $draftId != -1) {
                $reportNo = $commonTbl->generateReportID($params['report_date']);
                if ($reportNo == false) {
                    return redirect()->back();
                }
                $reportTbl['report_id'] = $reportNo;
            } elseif (isset($reportId) && $reportId != '') {
                $reportNo = DecisionReport::where('id', $reportId)->where('state', REPORT_STATUS_REQUEST)->first();
                if ($reportNo == null) {
                    $reportNo = $commonTbl->generateReportID($params['report_date']);
                    $reportTbl['report_id'] = $reportNo;
                } else {
                    $insertId = $reportNo;
                    $reportNo = substr($reportNo->report_id, 0, 2);
                    // if($params['report_date'])
                    $reportDate = date('y', strtotime($params['report_date']));
                    if ($reportNo == $reportDate) {
                        $reportTbl['report_id'] = $insertId->report_id;
                    } else {
                        $reportTbl['report_id'] = $commonTbl->generateReportID($params['report_date']);
                    }
                }
            } else {
                $reportNo = $commonTbl->generateReportID($params['report_date']);
                if ($reportNo == false) {
                    return redirect()->back();
                }
                $reportTbl['report_id'] = $reportNo;
            }
        } else {
            $reportTbl['report_id'] = 0;
        }
        $reportTbl['obj_type'] = $params['object_type'];

        if (!isset($params['report_date']) || $params['report_date'] == EMPTY_DATE) {
            $reportTbl['report_date'] = null;
        } else {
            $reportTbl['report_date'] = $params['report_date'];
        }

        $reportTbl['flowid'] = $params['flowid'] ?? '';
        if ($params['object_type'] == OBJECT_TYPE_SHIP) {
            $reportTbl['shipNo'] = $params['shipNo'] ?? null;
            $reportTbl['voyNo'] = $params['voyNo'] ?? null;
            $reportTbl['obj_no'] = null;
            $reportTbl['obj_name'] = null;
        } elseif ($params['object_type'] == OBJECT_TYPE_PERSON) {
            $reportTbl['obj_no'] = $params['obj_no'] ?? null;
            if (isset($params['obj_no'])) {
                $reportTbl['obj_name'] = AccountPersonalInfo::where('id', $params['obj_no'])->first()->person;
            } else {
                $reportTbl['obj_name'] = '';
            }

            $reportTbl['shipNo'] = null;
            $reportTbl['voyNo'] = null;
        }

        if (isset($params['flowid']) && $params['flowid'] == REPORT_TYPE_CONTRACT) {
            $reportTbl['profit_type'] = null;
            $reportTbl['amount'] = null;
            $reportTbl['currency'] = null;
        } else {
            $reportTbl['profit_type'] = $params['profit_type'] ?? null;
            $reportTbl['amount'] = isset($params['amount']) ? _convertStr2Int($params['amount']) : 0;
            $reportTbl['currency'] = $params['currency'] ?? CNY_LABEL;
        }

        $reportTbl['depart_id'] = $params['depart_id'];
        $reportTbl['creator'] = $user->id;
        $reportTbl['content'] = $params['content'] ?? '';
        $reportTbl['remark'] = $params['remark'] ?? '';
        $reportTbl['state'] = $params['reportType'];
        $reportTbl['ishide'] = 0;
        $reportTbl->save();

        $isRegister = false;
        if (isset($reportId) && $reportId != '') {
            $lastId = $reportId;
            $isRegister = false;
        } else {
            $last = DecisionReport::orderBy('id', 'desc')->first();
            if ($last == null) {
                $lastId = 1;
            } else {
                $lastId = $last['id'];
            }
            $isRegister = true;
        }

        $attachmentTbl = new DecisionReportAttachment();
        if ($params['file_remove'] == '1') {
            $attachmentTbl->deleteRecord($lastId);
            $reportTbl['attachment'] = 0;
        } elseif ($request->hasFile('attachment')) {
            $reportTbl['attachment'] = 1;
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/reports/' . $params['flowid'] . '/', $name);
            $fileDir = public_path() . '/reports/' . $params['flowid'] . '/' . $name;
            $fileLink = '/reports/' . $params['flowid'] . '/' . $name;
            $ret = $attachmentTbl->updateAttach($lastId, $fileName, $fileDir, $fileLink);
        }

        $reportTbl->save();
        Session::put('last_session', true);

        if ($params['reportType'] != REPORT_STATUS_DRAFT) {
            return redirect('decision/receivedReport');
        }

        return redirect('decision/draftReport');
    }

    public function getACList(Request $request)
    {
        $param = $request->all();
        if (!isset($param['type']) || $param['type'] == '') {
            return response()->json([]);
        }

        $type = $param['type'];
        $ACList = AcItem::where('C_D', g_enum('ReportTypeData')[$type])->get();

        return response()->json($ACList);
    }

    public function ajaxGetReceive(Request $request)
    {
        $params = $request->all();
        $userid = Auth::user()->id;

        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getForDatatable($params);

        return response()->json($reportList);
    }

    public function ajaxGetDraft(Request $request)
    {
        $params = $request->all();
        $userid = Auth::user()->id;

        $decideTbl = new DecisionReport();
        $reportList = $decideTbl->getDraft($params, REPORT_STATUS_DRAFT);

        return response()->json($reportList);
    }

    public function ajaxReportDecide(Request $request)
    {
        $params = $request->all();
        $userid = Auth::user()->id;
        $userRole = Auth::user()->isAdmin;

        if ($userRole != SUPER_ADMIN) {
            return response()->json('-1');
        }

        $decideTbl = new DecisionReport();
        $ret = $decideTbl->decideReport($params);

        return response()->json($ret);
    }

    public function ajaxReportDetail(Request $request)
    {
        $params = $request->all();
        $userid = Auth::user()->id;
        $userRole = Auth::user()->isAdmin;

        Session::forget('reportFiles');

        $decideTbl = new DecisionReport();
        $retVal = $decideTbl->getReportDetail($params);

        return response()->json($retVal);
    }

    public function ajaxReportData(Request $request)
    {
        $params = $request->all();

        $shipList = ShipRegister::orderBy('id')->get();
        foreach ($shipList as $key => $item) {
            $shipList[$key]->NickName = $shipList[$key]->NickName == '' ? $shipList[$key]->shipName_En : $shipList[$key]->NickName;
        }

        if (isset($params['shipId'])) {
            $voyList = CP::where('Ship_ID', $params['shipId'])->orderBy('Voy_No', 'desc')->groupBy('Voy_No')->get();
        } else {
            $voyList = [];
        }

        $_lastSession = Session::get('last_session');
        if ($_lastSession == null) {
            $beforeReport = false;
        } else {
            $beforeReport = true;
        }

        return response()->json(['shipList' => $shipList, 'voyList' => $voyList]);
    }

    public function ajaxNoAttachments(Request $request)
    {
        $params = $request->all();

        $decideTbl = new DecisionReport();
        $ret = $decideTbl->noAttachments($params);

        return response()->json($ret);
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

        if (isset($params['id'])) {
            $id = $params['id'];
        } else {
            $id = 0;
        }

        $lastId = $id;
        $reportTbl = DecisionReport::find($lastId);
        $attachmentTbl = new DecisionReportAttachment();
        $hasFile = $request->file('file');
        if (isset($hasFile)) {
            $reportTbl['attachment'] = 1;
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/reports/' . $params['flowid'] . '/', $name);
            $fileDir = public_path() . '/reports/' . $params['flowid'] . '/' . $name;
            $fileLink = '/reports/' . $params['flowid'] . '/' . $name;
            $ret = $attachmentTbl->updateAttach($lastId, $fileName, $fileDir, $fileLink);

            $reportTbl->save();
        }

        return response()->json(1);
    }

    public function ajaxGetDepartment()
    {
        $retVal = Unit::where('parentId', '!=', 0)->get();

        return response()->json($retVal);
    }

    public function ajaxObject()
    {
        $retVal = AccountPersonalInfo::all();

        return response()->json($retVal);
    }

    public function ajaxDeleteReportAttach(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];

        $decisionTbl = new DecisionReportAttachment();

        $ret = $decisionTbl->deleteAttach($id);

        return response()->json($ret);
    }

    public function ajaxDelete(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];

        $selector = WaterList::where('report_id', $id);
        $water_records = $selector->first();
        if (!empty($water_records)) {
            $ret = 0;

            return response()->json($ret);
        }
        $selector = WaterList::whereRaw('FIND_IN_SET(?, remark) > 0', [$id]);
        $water_records = $selector->first();

        if (!empty($water_records)) {
            $ret = 0;

            return response()->json($ret);
        }

        ReportSave::where('orig_id', $id)->delete();
        $ret = DecisionReport::where('id', $id)->delete();

        return response()->json($ret);
    }

    public function ajaxCheckReport()
    {
        if (Auth::user()->isAdmin == STAFF_LEVEL_MANAGER || Auth::user()->pos == STAFF_LEVEL_MANAGER) {
            $isAdmin = 1;
        } elseif (Auth::user()->pos == STAFF_LEVEL_FINANCIAL) {
            $isAdmin = 2;
        } else {
            $isAdmin = 3;
        }

        $decision = new DecisionReport();

        if ($isAdmin == 1) {
            $retVal = $decision->checkReport();
        } elseif ($isAdmin == 2) {
            $retVal = $decision->checkBookReport();
        } else {
            $retVal = false;
        }

        return response()->json($retVal);
    }

    public function ajaxAnalyzeReport(Request $request)
    {
        $params = $request->all();

        $decideTbl = new DecisionReport();
        $ret = $decideTbl->analyzeReport($params['year']);

        return response()->json($ret);
    }
}
