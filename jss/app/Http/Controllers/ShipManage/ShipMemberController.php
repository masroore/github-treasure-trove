<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/16
 * Time: 6:25.
 */

namespace App\Http\Controllers\shipManage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Models\BreadCrumb;
use App\Models\ShipManage\Ship;

use App\Models\ShipManage\ShipRegister;
use App\Models\ShipManage\ShipType;
use App\Models\ShipMember\SecurityCert;
use App\Models\ShipMember\ShipBoardCareer;
use App\Models\ShipMember\ShipCapacityRegister;
use App\Models\ShipMember\ShipMember;
use App\Models\ShipMember\ShipMemberCapacity;
use App\Models\ShipMember\ShipMemberCapacityCareer;
use App\Models\ShipMember\ShipMemberCareer;
use App\Models\ShipMember\ShipMemberExaming;
use App\Models\ShipMember\ShipMemberOtherCert;
use App\Models\ShipMember\ShipMemberSchool;
use App\Models\ShipMember\ShipMemberSocial;
use App\Models\ShipMember\ShipMemberSubExaming;
use App\Models\ShipMember\ShipMemberTraining;
use App\Models\ShipMember\ShipPosition;
use App\Models\ShipTechnique\ShipPort;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class ShipMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('shipMember/shipMember');
    }

    public function loadShipMembers(Request $request)
    {
        Util::getMenuInfo($request);

        $shipId = $request->get('ship');
        $pos = $request->get('pos');
        $name = $request->get('name');
        $state = $request->get('state');

        if (empty($shipId)) {
            $shipId = null;
        }
        if (empty($pos)) {
            $pos = null;
        }
        if (empty($name)) {
            $name = null;
        }
        if (empty($state)) {
            $state = 2;
        }

//        echo "<script>alert($state)</script>";
        $shipList = ShipRegister::getShipListOnlyOrigin();
        $posList = ShipPosition::orderBy('id')->get();
        //全部
        if ($state == 3) {
            $list = ShipMember::getShipMemberListByKeyword($shipId, $pos, $name, null);
        } else {
            $list = ShipMember::getShipMemberListByKeyword($shipId, $pos, $name, $state);
        }

        foreach ($list as $member) {
            $capacityId = $member->CapacityID;
            $gmdssId = $member->GMDSSID;

            if (!empty($capacityId)) {
                $capacity = ShipMemberCapacity::find($capacityId);
                if (empty($capacity)) {
                    continue;
                }
                $member['capacity_Cn'] = $capacity->Capacity;
                $member['capacity_en'] = $capacity->Capacity_En;
            }
            if (!empty($gmdssId)) {
                $capacity = ShipMemberCapacity::find($gmdssId);
                if (empty($capacity)) {
                    continue;
                }
                $member['gmdss_Cn'] = $capacity->Capacity;
                $member['gmdss_en'] = $capacity->Capacity_En;
            }
        }

        return view(
            'shipMember.memberDirectory',
            ['list' => $list,
                'shipList' => $shipList,
                'posList' => $posList,
                'ship' => $shipId,
                'pos' => $pos,
                'name' => $name,
                'state' => $state,
            ]
        );
    }

    public function registerShipMember(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolder(true);
        } else {
            $shipList = ShipRegister::orderByRaw("FIELD(RegStatus , '2', '1', '3') ASC")->orderBy('id')->get();
        }

        $posList = ShipPosition::all();
        $portList = ShipPort::orderBy('Port_En')->get();
        $ksList = Ship::all();
        $typeList = ShipType::all();
        $capacityList = ShipMemberCapacity::orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();
        $list = $this->getMemberGeneralInfo();
        $nationList = DB::table('tb_dynamic_nationality')->select('name')->get();
        $securityType = SecurityCert::all();
        $state = Session::get('state');

        $memberId = $request->get('memberId');
        if ($memberId != '') {
            $info = ShipMember::find($memberId);
            $historyList = ShipBoardCareer::where('memberId', $memberId)->orderBy('FromDate')->get();

            $card = ShipMemberSocial::where('memberId', $memberId)->first();
            $career = ShipMemberCareer::where('memberId', $memberId)->orderBy('fromDate')->get();

            $capacity = ShipCapacityRegister::where('memberId', $memberId)->first();
            $capacity_career = ShipMemberCapacityCareer::where('memberId', $memberId)->orderBy('RegDate')->get();
            $school = ShipMemberSchool::where('memberId', $memberId)->orderBy('id')->get();

            $training = ShipMemberTraining::where('memberId', $memberId)->groupBy('CertSequence')->get();
            $othercert = ShipMemberOtherCert::where('memberId', $memberId)->get();

            $examingList = ShipMemberExaming::where('memberId', $memberId)->orderBy('ExamDate')->get();
            $subList = [];
            $examId = '';
            if (count($examingList) > 0) {
                $subList = ShipMemberSubExaming::where('ExamId', $examingList[0]['id'])->orderBy('create_at')->get();
                $examId = $examingList[0]['id'];
            }
            $codeList = ShipMemberExaming::select('ExamCode')->groupBy('ExamCode')->get();

            return view(
                'shipMember.register_member',
                ['info' => $info,
                    'shipList' => $shipList,
                    'posList' => $posList,
                    'portList' => $portList,
                    'ksList' => $ksList,
                    'memberId' => $memberId,

                    'historyList' => $historyList,
                    'typeList' => $typeList,

                    'card' => $card,
                    'careerList' => $career,

                    'capacity' => $capacity,
                    'capacity_career' => $capacity_career,
                    'schoolList' => $school,
                    'capacityList' => $capacityList,

                    'security' => $securityType,
                    'training' => $training,
                    'othercert' => $othercert,

                    'examingList' => $examingList,
                    'examId' => $examId,
                    'subList' => $subList,
                    'codeList' => $codeList,
                    'list' => $list,
                    'state' => $state,
                    'nationList' => $nationList,
                    'breadCrumb' => $breadCrumb,
                ]
            );
        }
        //return view('shipMember.register_member', ['shipList'=>$shipList, 'posList'=>$posList, 'ksList'=>$ksList, 'typeList'=>$typeList, 'state'=>$state]);
        return view(
            'shipMember.register_member',
                //[   'info'      =>      ['id' => -1, 'ShipId' => '', 'Duty' => '', 'sign_on_off' => '', 'sign_on_off' => '', 'ShipID_Book' => '', 'DutyID_Book' => '1', 'IssuedDate' => '', 'ExpiryDate' => '', 'ShipID_organization' => '', 'pos' => '', 'scanPath' => '', 'Remarks' => '', 'crewNum' => '', 'realname' => '', 'Surname' => '', 'GivenName' => '', 'Sex' => 0, 'birthday' => '', 'BirthPlace' => '', 'address' => '', 'tel' => '', 'phone' => '', 'RegDate' => '', 'DelDate' => '', 'crewPhoto' => '', 'signPhoto' => '', 'RegStatus' => '', 'DateOnboard' => ''],
                  ['info' => ['id' => -1, 'ShipId' => '', 'Duty' => '', 'sign_on_off' => '', 'sign_on_off' => '', 'ShipID_Book' => '', 'DutyID_Book' => '0', 'PortID_Book' => '', 'IssuedDate' => '', 'ExpiryDate' => '', 'ShipID_organization' => '', 'pos' => '', 'scanPath' => '', 'Remarks' => '', 'crewNum' => '', 'realname' => '', 'BirthCountry' => '', 'GivenName' => '', 'Sex' => 0, 'birthday' => '', 'BirthPlace' => '', 'address' => '', 'tel' => '', 'phone' => '', 'RegDate' => '', 'DelDate' => '', 'crewPhoto' => '', 'signPhoto' => '', 'RegStatus' => '', 'DateOnboard' => '', 'DateOffboard' => '', 'Nationality' => '', 'CertNo' => '', 'OtherContacts' => '', 'BankInformation' => '', 'WageCurrency' => '', 'PassportNo' => '', 'PassportIssuedDate' => '', 'PassportExpiryDate' => '', 'Salary' => '', 'ShipType' => ''],
                      'shipList' => $shipList,
                      'posList' => $posList,
                      'portList' => $portList,
                      'ksList' => $ksList,
                      'memberId' => null,

                      'historyList' => null,
                      'typeList' => $typeList,

                      'card' => null,
                      'careerList' => null,

                      'capacity' => null,
                      'capacity_career' => null,
                      'schoolList' => null,
                      'capacityList' => $capacityList,

                      'security' => $securityType,
                      'training' => null,
                      'othercert' => null,

                      'examingList' => null,
                      'examId' => null,
                      'subList' => null,
                      'codeList' => null,
                      'list' => $list,
                      'nationList' => $nationList,
                      'state' => $state,
                      'breadCrumb' => $breadCrumb,
                  ]
        );
    }

    public function showShipMemberDataTab(Request $request)
    {
        $memberId = $request->get('memberId');
        if (!empty($memberId)) {
            $info = ShipMember::find($memberId);

            $shipList = ShipRegister::where('RegStatus', '!=', 3)->select('shipName_En', 'RegNo')->get();
            $posList = ShipPosition::all();
            $ksList = Ship::all();
            $typeList = ShipType::all();
            $historyList = ShipBoardCareer::where('memberId', $memberId)->orderBy('FromDate')->get();

            return view('shipMember.member_main_tab', ['info' => $info, 'shipList' => $shipList, 'posList' => $posList, 'ksList' => $ksList, 'historyList' => $historyList, 'typeList' => $typeList]);

            $capacity = ShipCapacityRegister::where('memberId', $memberId)->first();
            $capacity_career = ShipMemberCapacityCareer::where('memberId', $memberId)->get();
            $school = ShipMemberSchool::where('memberId', $memberId)->orderBy('id')->get();
            $typeList = ShipMemberCapacity::orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();
            $capacityList = ShipMemberCapacity::orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();

            return view('shipMember.member_capacity_tab', ['memberId' => $memberId, 'capacity' => $capacity, 'careerList' => $career, 'schoolList' => $school, 'capacityList' => $capacityList]);

            $training = ShipMemberTraining::where('memberId', $memberId)->first();

            return view('shipMember.member_training_tab', ['memberId' => $memberId, 'training' => $training]);

            $examingList = ShipMemberExaming::where('memberId', $memberId)->orderBy('ExamDate')->get();
            $subList = [];
            if (count($examingList) > 0) {
                $subList = ShipMemberSubExaming::where('ExamId', $list[0]['id'])->orderBy('create_at')->get();
            }
            $codeList = ShipMemberExaming::select('ExamCode')->groupBy('ExamCode')->get();

            return view('shipMember.member_examing_tab', ['examList' => $list, 'subList' => $subList, 'codeList' => $codeList]);
        }
    }

    public function deleteShipMember(Request $request)
    {
        $dataId = $request->get('dataId');
        $memberData = ShipMember::find($dataId);

        if (null === $memberData) {
            return -1;
        }
        $memberData->delete();
        ShipMemberSchool::where('memberId', $dataId)->delete();
        ShipMemberCapacityCareer::where('memberId', $dataId)->delete();
        ShipBoardCareer::where('memberId', $dataId)->delete();

        return 1;
    }

    public function updateMemberInfo(Request $request)
    {
        //dump($request);
        //die();
        $memberId = $this->updateMemberMainInfo($request);
        if ($memberId != '') {
            $this->updateMemberMainData($request, $memberId);
            $this->updateMemberCapacityData($request, $memberId);
            $this->updateMemberTrainingData($request, $memberId);
            $this->updateMemberOtherCert($request, $memberId);

            return redirect('shipMember/registerShipMember?memberId=' . $memberId);
        }

        return back()->with(['state' => 'error']);
    }

    public function updateMemberMainInfo(Request $request)
    {
        $memberId = $request->get('memberId');
        $crewNum = $request->get('crewNum');

        $isExist = ShipMember::where('crewNum', $crewNum)->first();
        if (!empty($isExist) && ($isExist['id'] != $memberId) && $crewNum != '') {
            return '';
        }
        if ($memberId != '') {
            $member = ShipMember::find($memberId);
        } else {
            $member = new ShipMember();
        }

        $member['crewNum'] = $crewNum;
        $member['realname'] = $request->get('realname');

        $member['GivenName'] = $request->get('GivenName');
        $member['Sex'] = $request->get('Sex');
        $birthday = $request->get('birthday');
        if (empty($birthday)) {
            $birthday = null;
        }
        $member['birthday'] = $birthday;
        $member['RegStatus'] = $request->get('RegStatus');
        $member['BirthPlace'] = $request->get('BirthPlace');
        $member['BirthCountry'] = $request->get('BirthCountry');
        $dateStr = $request->get('IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $member['IssuedDate'] = $dateStr;
        $dateStr = $request->get('ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $member['ExpiryDate'] = $dateStr;

        $member['tel'] = $request->get('tel');
        $member['address'] = $request->get('address');
        $member['phone'] = $request->get('phone');
        $member['Nationality'] = $request->get('Nationality');
        $member['BankInformation'] = $request->get('BankInformation');
        $member['OtherContacts'] = $request->get('OtherContacts');
        $member['PassportNo'] = $request->get('PassportNo');
        $member['CertNo'] = $request->get('CertNo');
        $member['Salary'] = $request->get('Salary');
        $member['WageCurrency'] = $request->get('WageCurrency');
        $regDate = $request->get('RegDate');
        if (empty($regDate)) {
            $regDate = date('Y-m-d');
        }
        $member['RegDate'] = $regDate;

        $delDate = $request->get('DelDate');
        if (empty($delDate)) {
            $delDate = null;
        }
        $member['DelDate'] = $delDate;

        $photo = $request->file('avatar');
        if (isset($photo)) {
            $ext = $photo->getClientOriginalExtension();
            $photoPath = Util::makeUploadFileName() . '.' . $ext;
            $photo->move(public_path('uploads/crewPhoto'), $photoPath);
            $member['crewPhoto'] = $photoPath;
        }
        $member->save();

        if ($memberId == '') {
            $memberId = ShipMember::all()->last()->id;
        }

        return $memberId;
    }

    public function updateMemberMainData(Request $request, $memberId): void
    {
        $member = ShipMember::find($memberId);

        $member['ShipId'] = $request->get('ShipId');
        /*
        if($request->has('Duty')) {
            $member['Duty'] = $request->get('Duty');
        }
        */

        $member['sign_on_off'] = $request->get('sign_on_off');
        if ($request->has('DateOnboard')) {
            $member['DateOnboard'] = $request->get('DateOnboard');
        } else {
            $member['DateOnboard'] = null;
        }

        if ($request->has('DateOffboard')) {
            $member['DateOffboard'] = $request->get('DateOffboard');
        } else {
            $member['DateOffboard'] = null;
        }

        if ($request->has('ShipID_Book')) {
            $member['ShipID_Book'] = $request->get('ShipID_Book');
        }

        if ($request->has('DutyID_Book')) {
            $member['DutyID_Book'] = $request->get('DutyID_Book');
        }

        if ($request->has('PortID_Book')) {
            $member['PortID_Book'] = $request->get('PortID_Book');
        }

        if ($request->has('PassportIssuedDate')) {
            $member['PassportIssuedDate'] = $request->get('PassportIssuedDate');
        } else {
            $member['PassportIssuedDate'] = null;
        }

        if ($request->has('PassportExpiryDate')) {
            $member['PassportExpiryDate'] = $request->get('PassportExpiryDate');
        } else {
            $member['PassportExpiryDate'] = null;
        }

        if ($request->has('ShipID_organization')) {
            $member['ShipID_organization'] = $request->get('ShipID_organization');
        }

        if ($request->has('pos')) {
            $member['pos'] = $request->get('pos');
        }
        $member['Remarks'] = $request->get('Remarks');

        $file = $request->file('crewCard');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/crewCard'), $cardPath);

            $member['ScanState'] = 1;
            $member['scanPath'] = $cardPath;
        }
        $member->save();

        $school_goc = ShipBoardCareer::where('memberId', $memberId)->get();
        ShipBoardCareer::where('memberId', $memberId)->delete();

        $FromDate = $request->get('FromDate');
        $ToDate = $request->get('ToDate');
        $ShipName = $request->get('ShipName');
        $DutyID = $request->get('DutyID');
        $GT = $request->get('GT');
        $ShipType = $request->get('ShipType');
        $Power = $request->get('Power');
        $TradingArea = $request->get('TradingArea');
        foreach ($FromDate as $index => $data) {
            if ($FromDate[$index] == '' && $ToDate[$index] == '' && $ShipName[$index] == '' && $DutyID[$index] == '0' && $GT[$index] == '' && $ShipType[$index] == '0' && $Power[$index] == '' && $TradingArea[$index] == '') {
                continue;
            }

            $career = new ShipBoardCareer();
            $career['memberId'] = $memberId;
            $dateStr = $FromDate[$index];
            if ($dateStr == '') {
                $dateStr = null;
            }
            $career['FromDate'] = $dateStr;

            $dateStr = $ToDate[$index];
            if ($dateStr == '') {
                $dateStr = null;
            }
            $career['ToDate'] = $dateStr;

            $career['Ship'] = $ShipName[$index];
            $career['DutyID'] = $DutyID[$index];
            $career['GrossTonage'] = $GT[$index];
            $career['ShipType'] = $ShipType[$index];
            $career['Power'] = $Power[$index];
            $career['SailArea'] = $TradingArea[$index];
            $career->save();
        }
    }

    public function updateMemberCapacityData(Request $request, $memberId): void
    {
        $capacity = ShipCapacityRegister::where('memberId', $memberId)->first();
        if (null === $capacity) {
            $capacity = new ShipCapacityRegister();
            $capacity['memberId'] = $memberId;
        }

        $capacity['ItemNo'] = $request->get('ItemNo');
        $capacity['CapacityID'] = $request->get('CapacityID');
        $file = $request->file('GOC');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/capacity'), $cardPath);
            $capacity['GOC'] = $cardPath;
        }

        $dateStr = $request->get('COC_IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COC_IssuedDate'] = $dateStr;

        $dateStr = $request->get('COC_ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COC_ExpiryDate'] = $dateStr;
        $capacity['COC_Remarks'] = $request->get('COC_Remarks');

        // ----------------------------------
        $capacity['GMDSS_NO'] = $request->get('GMDSS_NO');
        $capacity['GMDSSID'] = $request->get('GMDSSID');
        $file = $request->file('GMDSS_Scan');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/capacity'), $cardPath);
            $capacity['GMDSS_Scan'] = $cardPath;
        }

        $dateStr = $request->get('GMD_IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['GMD_IssuedDate'] = $dateStr;

        $dateStr = $request->get('GMD_ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['GMD_ExpiryDate'] = $dateStr;

        $capacity['GMD_Remarks'] = $request->get('GMD_Remarks');

        // ----------------------------------
        $capacity['COENo'] = $request->get('COENo');
        $capacity['COEId'] = $request->get('COEId');
        $file = $request->file('COE_Scan');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/capacity'), $cardPath);
            $capacity['COE_Scan'] = $cardPath;
        }

        $dateStr = $request->get('COE_IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COE_IssuedDate'] = $dateStr;

        $dateStr = $request->get('COE_ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COE_ExpiryDate'] = $dateStr;

        $capacity['COE_Remarks'] = $request->get('COE_Remarks');

        // ----------------------------------
        $capacity['COE_GOCNo'] = $request->get('COE_GOCNo');
        $capacity['COE_GOCId'] = $request->get('COE_GOCId');
        $file = $request->file('COE_GOC_Scan');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/capacity'), $cardPath);
            $capacity['COE_GOC_Scan'] = $cardPath;
        }

        $dateStr = $request->get('COE_GOC_IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COE_GOC_IssuedDate'] = $dateStr;

        $dateStr = $request->get('COE_GOC_ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['COE_GOC_ExpiryDate'] = $dateStr;

        $capacity['COE_GOC_Remarks'] = $request->get('COE_GOC_Remarks');

        // ----------------------------------
        $capacity['WatchNo'] = $request->get('WatchNo');
        $capacity['WatchID'] = $request->get('WatchID');
        $file = $request->file('Watch_Scan');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $cardPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/capacity'), $cardPath);
            $capacity['Watch_Scan'] = $cardPath;
        }

        $dateStr = $request->get('Watch_IssuedDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['Watch_IssuedDate'] = $dateStr;

        $dateStr = $request->get('Watch_ExpiryDate');
        if (empty($dateStr)) {
            $dateStr = null;
        }
        $capacity['Watch_ExpiryDate'] = $dateStr;

        $capacity['Watch_Remarks'] = $request->get('Watch_Remarks');
        $capacity->save();

        $member = ShipMember::find($memberId);
        $member['QualificationClass'] = $capacity['CapacityID'];

        $member->save();

        ShipMemberCapacityCareer::where('memberId', $memberId)->delete();
        for ($i = 0; $i < 20; ++$i) {
            $varname = 'capacity_' . $i;
            $capacityId = $request->get($varname);
            if (isset($capacityId)) {
                $varName = '_' . $i;
                $career = new ShipMemberCapacityCareer();

                $career['memberId'] = $memberId;
                $dateStr = $request->get('RegDate' . $varName);
                if (empty($dateStr)) {
                    $dateStr = null;
                }
                $career['RegDate'] = $dateStr;

                $career['CapacityID'] = $request->get('CapacityID' . $varName);
                $scan = $request->get('GOC' . $varName);
                if ($scan == 'on') {
                    $career['GOC'] = 1;
                } else {
                    $career['GOC'] = 0;
                }
                $career['RegReason'] = $request->get('RegReason' . $varName);
                $career['Remarks'] = $request->get('Remarks_Career' . $varName);
                if (null === $career['RegDate'] && ($career['CapacityID'] == 0) && empty($career['RegReason']) && empty($career['Remarks'])) {
                    continue;
                }

                $career->save();
            }
        }
    }

    public function updateMemberTrainingData(Request $request, $memberId)
    {
        $STCW = $request->get('Train_STCW');
        $CertNo = $request->get('Train_CertNo');
        $CertIssue = $request->get('Train_CertIssue');
        $CertExpire = $request->get('Train_CertExpire');
        $IssuedBy = $request->get('Train_IssuedBy');

        $result = ShipMemberTraining::insertMemberTrainning($memberId, $STCW, $CertNo, $CertIssue, $CertExpire, $IssuedBy);

        return $result;
    }

    public function updateMemberOtherCert(Request $request, $memberId)
    {
        $CertName = $request->get('Other_Name');
        $CertNo = $request->get('Other_CertNo');
        $CertIssue = $request->get('Other_CertIssue');
        $CertExpire = $request->get('Other_CertExpire');
        $IssuedBy = $request->get('Other_IssuedBy');

        $result = ShipMemberOtherCert::insertMemberOtherCert($memberId, $CertName, $CertNo, $CertIssue, $CertExpire, $IssuedBy);

        return $result;
    }

    public function totalShipMember(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $regShip = $request->get('regShip');
        $bookShip = $request->get('bookShip');
        $origShip = $request->get('origShip');
        $regStatus = $request->get('regStatus');

        $list = ShipMember::getTotalMemberList($regShip, $bookShip, $origShip, $regStatus);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        $ko_ship_list = Ship::select('id', 'name')->get();
        foreach ($list as $member) {
            //$ship = ShipRegister::find($member['ShipID_Book']);
            $ship = ShipRegister::where('IMO_No', $member['ShipId'])->first();
            if ($ship) {
                $member['book_ship'] = $ship['shipName_En'];
            }
            $ship = Ship::find($member['ShipID_organization']);
            if ($ship) {
                $member['origin_ship'] = $ship['name'];
            }
            $duty = ShipPosition::find($member['DutyID_Book']);
            if ($duty) {
                $member['book_duty'] = $duty['Duty'];
            }

            $duty = ShipPosition::find($member['pos']);
            if ($duty) {
                $member['orgin_duty'] = $duty['Duty'];
            }
        }

        return view('shipMember.total_member_list', [
            'list' => $list,
            'shipList' => $shipList,
            'ko_ship_list' => $ko_ship_list,
            'regShip' => $regShip,
            'bookShip' => $bookShip,
            'origShip' => $origShip,
            'regStatus' => $regStatus,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function memberCertList(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $list = ''; //ShipMember::getMemberCertList($shipId, $posId, $capacityId, $month, -1);
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }
        $posList = ShipPosition::all();
        $capacityList = ShipMemberCapacity::orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();
        $securityType = SecurityCert::all();

        return view(
            'shipMember.member_cert_list',
            ['list' => $list,
                'shipList' => $shipList,
                'posList' => $posList,
                'capacityList' => $capacityList,
                'security' => $securityType,
                'breadCrumb' => $breadCrumb,
            ]
        );
    }

    public function getMemberGeneralInfo()
    {
        $member_infolist = ShipMember::select('id', 'crewNum', 'realname', 'Sex', 'birthday', 'Nationality', 'RegStatus')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return $member_infolist;
    }

    public function ajaxGetWholeList(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForWholeDatatable($params);

        return response()->json($ret);
    }

    public function ajaxSearchMember(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForDatatable($params);

        return response()->json($ret);
    }

    public function ajaxSearchMemberAll(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForDatatableAll($params);

        return response()->json($ret);
    }

    public function ajaxSearchMemberWithWage(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForWageDatatable($params);

        return response()->json($ret);
    }

    public function ajaxSearchMemberWithSendWage(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForSendWageDatatable($params);

        return response()->json($ret);
    }

    public function ajaxGetShipWageList(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForShipWageListDatatable($params);

        return response()->json($ret);
    }

    public function ajaxGetShipMemberList(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForMemberWageListDatatable($params);

        return response()->json($ret);
    }

    public function ajaxShipMemberCertList(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getForCertDatatable($params);

        return response()->json($ret);
    }

    public function ajaxSearchWageById(Request $request)
    {
        $params = $request->all();
        $tbl = new ShipMember();
        $ret = $tbl->getWageById($params);

        return response()->json($ret);
    }

    public function autocomplete(Request $request)
    {
        $names = [];

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            $selector = ShipMember::whereIn('ShipId', $ids);
        } else {
            $selector = ShipMember::select('*');
        }

        if ($request->sign == 'true') {
            $selector = $selector->select('realname')
                ->whereNotNull('DateOnboard')
                ->where(function ($query): void {
                    $today = date('Y-m-d');
                    $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
                })
                ->where('realname', 'like', '%' . $request->terms . '%');
        } else {
            $today = date('Y-m-d');
            $selector = $selector->select('realname')
                ->whereNull('DateOnboard')->orWhere('DateOffboard', '<=', $today)
                ->where('realname', 'like', '%' . $request->terms . '%');
        }

        $names = $selector->get();

        $data = [];
        foreach ($names as $name) {
            $data[] = $name->realname;
        }

        return response()->json($data);
    }

    public function autocompleteAll(Request $request)
    {
        $names = [];

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            $names = ShipMember::select('realname')->whereIn('ShipId', $ids)
                ->where('realname', 'like', '%' . $request->terms . '%')->get();
        } else {
            $names = ShipMember::select('realname')
                ->where('realname', 'like', '%' . $request->terms . '%')->get();
        }

        $data = [];
        foreach ($names as $name) {
            $data[] = $name->realname;
        }

        return response()->json($data);
    }

    public function getCount(Request $request)
    {
        $params = $request->all();
        $type = $params['signon'];
        if ($type == 'true') {
            $count = ShipMember::whereNotNull('DateOnboard')
                ->where(function ($query): void {
                    $today = date('Y-m-d');
                    $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
                })->count();
        } else {
            $today = date('Y-m-d');
            $count = ShipMember::whereNull('DateOnboard')->orWhere('DateOffboard', '<=', $today)->count();
        }

        return $count;
    }
}
