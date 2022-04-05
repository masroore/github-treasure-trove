<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/13
 * Time: 9:39.
 */

namespace App\Http\Controllers\shipManage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Models\BreadCrumb;
use App\Models\Convert\VoyLog;
use App\Models\Decision\DecisionReport;
use App\Models\Operations\CP;
use App\Models\ShipManage\Ctm;
use App\Models\ShipManage\Evaluation;
use App\Models\ShipManage\Fuel;
use App\Models\ShipManage\Ship;
use App\Models\ShipManage\ShipCertList;

use App\Models\ShipManage\ShipCertRegistry;
use App\Models\ShipManage\ShipDiligence;
use App\Models\ShipManage\ShipEquipment;
use App\Models\ShipManage\ShipEquipmentMainKind;
use App\Models\ShipManage\ShipEquipmentPart;
use App\Models\ShipManage\ShipEquipmentProperty;
use App\Models\ShipManage\ShipEquipmentRegKind;
use App\Models\ShipManage\ShipEquipmentRequire;
use App\Models\ShipManage\ShipEquipmentRequireKind;
use App\Models\ShipManage\ShipEquipmentSubKind;
use App\Models\ShipManage\ShipEquipmentUnits;
use App\Models\ShipManage\ShipFreeBoard;
use App\Models\ShipManage\ShipIssaCode;
use App\Models\ShipManage\ShipIssaCodeNo;
use App\Models\ShipManage\ShipMaterialCategory;
use App\Models\ShipManage\ShipMaterialRegistry;
use App\Models\ShipManage\ShipMaterialSubKind;
use App\Models\ShipManage\ShipOthers;
use App\Models\ShipManage\ShipRegister;
use App\Models\ShipManage\ShipType;
use App\Models\ShipMember\ShipMember;
use App\Models\ShipMember\ShipMemberCapacity;
use App\Models\ShipMember\ShipPosition;
use App\Models\ShipMember\ShipSTCWCode;
use App\Models\ShipMember\ShipTrainingCourse;
use App\Models\ShipTechnique\EquipmentUnit;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Lang;

class ShipRegController extends Controller
{
    protected $userInfo;

    private $control = 'shipManage';

    protected $__CERT_EXCEL = [
        ['Nationality / Registry', 'COR'],
        ['Minimum Safe Manning', 'MSMC'],
        ['Tonnage', 'ITC'],
        ['Load Line', 'ILL'],
        ['IOPP', 'IOPP-A'],
        ['Safety Construction', 'SC'],
        ['Safety Equipment', 'SE'],
        ['Safety Radio', 'SR'],
        ['CLC', 'BCC'],
        ['DOC', 'DOC'],
        ['SMC', 'SMC'],
        ['ISSC', 'ISSC'],
        ['Life saving appliances Provided for a total number of', 'SE'],
    ];

    protected $__MEMBER_EXCEL_COC = [
        ['MASTER', 'captain'],
        ['CHIEF MATE', 'C / Officer'],
        ['2nd DECK OFFICER', '2 / Officer'],
        ['3rd DECK OFFICER', '3 / Officer'],
        ['RADIO OFFICER', 'Radio Officer personnel'], ];

    protected $__MEMBER_EXCEL_GOC = [
        ['CHIEF ENGINEER', 'C / Engineer'],
        ['2nd ENGINEER OFFICER', '2 / Engineer'],
        ['3rd ENGINEER OFFICER', '3 / Engineer'],
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('shipManage/shipinfo');
    }

    public function loadShipGeneralInfos(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ship_infolist = ShipRegister::getShipForHolderWithDelete();
        } else {
            $ship_infolist = ShipRegister::orderBy('id')->get();
        }

        // var_dump($ship_infolist);die;
        $memberCertXls['COC'] = $this->__MEMBER_EXCEL_COC;
        $memberCertXls['GOC'] = $this->__MEMBER_EXCEL_GOC;

        $params = $request->all();

        if (isset($params['id'])) {
            $ship_id = $params['id'];
        } else {
            // $ship_id = ShipRegister::orderBy('id')->first()->id;
            if (count($ship_infolist) > 0) {
                $ship_id = $ship_infolist[0]->id;
            } else {
                return view('shipManage.shipinfo', [
                    'list' => [],
                    'shipInfo' => [],
                    'shipName' => '',
                    'elseInfo' => ['cert' => []],
                    'id' => 0,
                    'memberCertXls' => $memberCertXls,
                    'breadCrumb' => $breadCrumb,
                ]);
            }
        }

        $shipRegTbl = new ShipRegister();
        $elseInfo = $shipRegTbl->getShipForExcel($ship_id, $this->__CERT_EXCEL);

        $shipInfo = ShipRegister::where('id', $ship_id)->first();
        $shipCertList = ShipCertRegistry::where('ship_id', $ship_id)->get();

        $imo_no = $shipInfo->IMO_No;
        $shipName = $shipInfo->shipName_En;
        $shipTypeTbl = ShipType::where('id', $shipInfo->ShipType)->first();
        $shipInfo['ShipType'] = isset($shipTypeTbl) ? $shipTypeTbl['ShipType'] : '';

        $shipMembers = ShipMember::where('ShipId', $imo_no)->get();

        return view('shipManage.shipinfo', [
            'list' => $ship_infolist,
            'shipInfo' => $shipInfo,
            'shipName' => $shipName,
            'elseInfo' => $elseInfo,
            'id' => $ship_id,
            'memberCertXls' => $memberCertXls,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function exportShipInfo(Request $request)
    {
        $params = $request->all();

        if (isset($params['id'])) {
            $ship_id = $params['id'];
        } else {
            $ship_id = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->first()->id;
        }

        $ship_id ??= 0;

        $shipInfo = ShipRegister::where('id', $ship_id)->first();
        $shipName = $shipInfo->NickName;
        if (!isset($shipName) || $shipName == '') {
            $shipName = $shipInfo->shipName_En;
        }

        $shipTypeTbl = ShipType::where('id', $shipInfo->ShipType)->first();
        $shipInfo['ShipType'] = isset($shipTypeTbl) ? $shipTypeTbl['ShipType'] : '';

        return view('shipManage.shipinfo', [
            'shipInfo' => $shipInfo,
            'is_excel' => 1,
            'excel_name' => $shipName . '_SHIP PARTICULARS_' . date('Ymd'),
            'shipName' => $shipName,
            'id' => $ship_id,
        ]);
    }

    public function registerShipData(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $shipList = Ship::all();
        $shipType = ShipType::orderByRaw('CAST(OrderNo AS SIGNED) ASC')->get();

        $shipId = $request->get('shipId');
        $params = $request->all();
        if (isset($params['type']) && $params['type'] == 'new') {
            $shipId = 0;
        } elseif (null === $shipId) {
            $user_pos = Auth::user()->pos;
            if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
                $ids = Auth::user()->shipList;
                $ids = explode(',', $ids);
                $first_ship = ShipRegister::whereIn('IMO_No', $ids)->orderBy('id')->first();
            } else {
                $first_ship = ShipRegister::orderBy('id')->first();
            }

            if (empty($first_ship)) {
                $shipId = '0';
            } else {
                $shipId = $first_ship->id;
            }
        }
        if ($shipId != '0') {
            $shipInfo = ShipRegister::where('id', $shipId)->first();
            $freeBoard = ShipFreeBoard::where('shipId', $shipId)->first();
        } else {
            $shipInfo = new ShipRegister();
            $freeBoard = new ShipFreeBoard();
        }

        $status = Session::get('status');

        $ship_infolist = $this->getShipGeneralInfo(true);

        return view('shipManage.shipregister', [
            'shipList' => $shipList,
            'shipType' => $shipType,
            'shipInfo' => $shipInfo,
            'freeBoard' => $freeBoard,
            'status' => $status,
            'list' => $ship_infolist,

            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function saveShipData(Request $request)
    {
        $params = $request->all();
        $shipId = $request->get('shipId');
        $freeId = $request->get('freeId');

        if ($shipId > 0) {
            $isRegister = false;
            $shipData = ShipRegister::find($shipId);
        } else {
            $isRegister = true;
            $shipData = new ShipRegister();
        }

        $commonLang = Lang::get('common');
        $lastShipId = $this->saveShipGeneralData($params, $shipData);
        if ($lastShipId != false && $lastShipId != '') {
            $this->saveShipHullData($params, $lastShipId, $freeId);
            $this->saveShipMachineryData($params, $lastShipId);
            $this->saveShipRemarksData($params, $lastShipId);
            $status = $isRegister == true ? $commonLang['message']['register']['success'] : $commonLang['message']['update']['success'];

            return redirect(url('shipManage/registerShipData?shipId=' . $lastShipId));
        }
        //$status = $isRegister == true ? $commonLang['message']['register']['failed'] : $commonLang['message']['update']['failed'];
        return back()->with(['status' => 'error']);

        //return redirect(url('shipManage/registerShipData?shipId=' . $lastShipId));
    }

    public function saveShipGeneralData($params, $shipData)
    {
        //try {
        $shipId = $params['shipId'];
        $IMO_No = $params['IMO_No'];
        $isExist = ShipRegister::where('IMO_No', $IMO_No)->first();
        if (!empty($isExist) && ($isExist['id'] != $shipId) && $IMO_No != '') {
            return '';
        }
        $shipData['shipName_Cn'] = $params['shipName_Cn'];
        $shipData['shipName_En'] = $params['shipName_En'];
        $shipData['NickName'] = $params['NickName'];
        $shipData['Class'] = $params['Class'];
        $shipData['RegNo'] = $params['RegNo'];
        $shipData['RegStatus'] = $params['RegStatus'];
        $shipData['CallSign'] = $params['CallSign'];
        $shipData['MMSI'] = $params['MMSI'];
        $shipData['IMO_No'] = $params['IMO_No'];
        $shipData['INMARSAT'] = $params['INMARSAT'] ?? null;
        $shipData['order'] = isset($params['order']) ? ($params['order'] == '' ? 0 : $params['order']) : 0;
        $shipData['OriginalShipName'] = $params['OriginalShipName'];
        $shipData['FormerShipName'] = $params['FormerShipName'];
        $shipData['SecondFormerShipName'] = $params['SecondFormerShipName'];
        $shipData['Flag'] = $params['Flag'];
        $shipData['PortOfRegistry'] = $params['PortOfRegistry'];
        $shipData['Owner_Cn'] = $params['Owner_Cn'];
        $shipData['OwnerAddress_Cn'] = $params['OwnerAddress_Cn'];
        $shipData['OwnerTelnumber'] = $params['OwnerTelnumber'];
        $shipData['OwnerFax'] = $params['OwnerFax'];
        $shipData['OwnerEmail'] = $params['OwnerEmail'];
        $shipData['ISM_Cn'] = $params['ISM_Cn'];
        $shipData['ISMAddress_Cn'] = $params['ISMAddress_Cn'];
        $shipData['ISMTelnumber'] = $params['ISMTelnumber'];
        $shipData['ISMFax'] = $params['ISMFax'];
        $shipData['ISMEmail'] = $params['ISMEmail'];
        $shipData['ShipType'] = $params['ShipType'] == '' ? null : $params['ShipType'];
        $shipData['GrossTon'] = $params['GrossTon'] == '' ? null : $params['GrossTon'];
        $shipData['LOA'] = $params['LOA'] == '' ? null : $params['LOA'];
        $shipData['NetTon'] = $params['NetTon'] == '' ? null : $params['NetTon'];
        $shipData['LBP'] = $params['LBP'] == '' ? null : $params['LBP'];
        $shipData['Deadweight'] = $params['Deadweight'] == '' ? null : $params['Deadweight'];
        $shipData['Length'] = $params['Length'] == '' ? null : $params['Length'];
        $shipData['Displacement'] = $params['Displacement'] == '' ? null : $params['Displacement'];
        $shipData['BM'] = $params['BM'] == '' ? null : $params['BM'];
        $shipData['Ballast'] = $params['Ballast'] == '' ? null : $params['Ballast'];
        $shipData['DM'] = $params['DM'] == '' ? null : $params['DM'];
        $shipData['FuelBunker'] = $params['FuelBunker'];
        $shipData['ShipBuilder'] = $params['ShipBuilder'];
        $shipData['KeelDate'] = $params['KeelDate'];
        $shipData['DeckErection_B'] = $params['DeckErection_B'] == '' ? null : $params['DeckErection_B'];
        $shipData['LaunchDate'] = $params['LaunchDate'];
        $shipData['DeckErection_F'] = $params['DeckErection_F'] == '' ? null : $params['DeckErection_F'];
        $shipData['DeliveryDate'] = $params['DeliveryDate'];
        $shipData['DeckErection_P'] = $params['DeckErection_P'] == '' ? null : $params['DeckErection_P'];
        $shipData['ConversionDate'] = $params['ConversionDate'];
        $shipData['DeckErection_H'] = $params['DeckErection_H'] == '' ? null : $params['DeckErection_H'];
        $shipData['RegDate'] = !isset($params['RegDate']) || $params['RegDate'] == '' ? null : $params['RegDate'];
        $shipData['RenewDate'] = !isset($params['RenewDate']) || $params['RenewDate'] == '' ? null : $params['RenewDate'];
        $shipData['KCExpiryDate'] = !isset($params['KCExpiryDate']) || $params['KCExpiryDate'] == '' ? null : $params['KCExpiryDate'];
        $shipData['ConditionalDate'] = !isset($params['ConditionalDate']) || $params['ConditionalDate'] == '' ? null : $params['ConditionalDate'];
        $shipData['DelDate'] = !isset($params['DelDate']) || $params['DelDate'] == '' ? null : $params['DelDate'];
        $shipData['Draught'] = !isset($params['Draught']) || $params['Draught'] == '' ? null : $params['Draught'];
        $shipData['BuildPlace_Cn'] = $params['BuildPlace_Cn'] ?? '';
        $shipData->save();

        return $shipData['id'];
        //} catch (\Exception $exception) {
        //	return false;
        //}
    }

    public function saveShipHullData($params, $shipId, $freeId)
    {
//    	try {
        if ($shipId > 0) {
            $shipData = ShipRegister::find($shipId);
        } else {
            $shipData = new ShipRegister();
        }
        $shipData['Hull'] = $params['Hull'] == '' ? null : $params['Hull'];
        $shipData['HullNotation'] = $params['HullNotation'] == '' ? null : $params['HullNotation'];
        $shipData['Machinery'] = $params['Machinery'] == '' ? null : $params['Machinery'];
        $shipData['MachineryNotation'] = $params['MachineryNotation'] == '' ? null : $params['MachineryNotation'];
        $shipData['Refrigerater'] = $params['Refrigerater'] == '' ? null : $params['Refrigerater'];
        $shipData['RefrigeraterNotation'] = $params['RefrigeraterNotation'] == '' ? null : $params['RefrigeraterNotation'];

        $shipData['HullNo'] = $params['HullNo'] == '' ? null : $params['HullNo'];
        $shipData['Decks'] = $params['Decks'] == '' ? null : $params['Decks'];
        $shipData['Bulkheads'] = $params['Bulkheads'] == '' ? null : $params['Bulkheads'];
        $shipData['NumberOfHolds'] = $params['NumberOfHolds'] == '' ? null : $params['NumberOfHolds'];
        $shipData['CapacityOfHoldsG'] = $params['CapacityOfHoldsG'] == '' ? null : $params['CapacityOfHoldsG'];
        $shipData['CapacityOfHoldsB'] = $params['CapacityOfHoldsB'] == '' ? null : $params['CapacityOfHoldsB'];
        $shipData['HoldsDetail'] = $params['HoldsDetail'] == '' ? null : $params['HoldsDetail'];
        $shipData['NumberOfHatchways'] = $params['NumberOfHatchways'] == '' ? null : $params['NumberOfHatchways'];
        $shipData['SizeOfHatchways'] = $params['SizeOfHatchways'] == '' ? null : $params['SizeOfHatchways'];
        $shipData['ContainerOnDeck'] = $params['ContainerOnDeck'] == '' ? null : $params['ContainerOnDeck'];
        $shipData['ContainerInHold'] = $params['ContainerInHold'] == '' ? null : $params['ContainerInHold'];
        $shipData['LiftingDevice'] = $params['LiftingDevice'] == '' ? null : $params['LiftingDevice'];
        $shipData['TK_TOP'] = $params['TK_TOP'] == '' ? null : $params['TK_TOP'];
        $shipData['ON_DECK'] = $params['ON_DECK'] == '' ? null : $params['ON_DECK'];
        $shipData['H_COVER'] = $params['H_COVER'] == '' ? null : $params['H_COVER'];
        $shipData->save();

        if ($freeId > 0) {
            $freeData = ShipFreeBoard::find($freeId);
        } else {
            $freeData = new ShipFreeBoard();
        }

        $freeData['shipId'] = $params['shipId'];
        $freeData['ship_type'] = $params['ship_type'];
        $freeData['new_ship'] = (isset($params['new_ship'])) ? ($params['new_ship'] == 'on' ? 1 : 0) : 0;
        $freeData['new_free_tropical'] = $params['new_free_tropical'] == '' ? null : $params['new_free_tropical'];
        $freeData['new_load_tropical'] = $params['new_load_tropical'] == '' ? null : $params['new_load_tropical'];
        $freeData['new_free_summer'] = $params['new_free_summer'] == '' ? null : $params['new_free_summer'];
        $freeData['new_free_winter'] = $params['new_free_winter'] == '' ? null : $params['new_free_winter'];
        $freeData['new_load_winter'] = $params['new_load_winter'] == '' ? null : $params['new_load_winter'];
        $freeData['new_free_winteratlantic'] = $params['new_free_winteratlantic'] == '' ? null : $params['new_free_winteratlantic'];
        $freeData['new_load_winteratlantic'] = $params['new_load_winteratlantic'] == '' ? null : $params['new_load_winteratlantic'];
        $freeData['new_free_fw'] = $params['new_free_fw'] == '' ? null : $params['new_free_fw'];
        $freeData['timber'] = isset($params['timber']) ? ($params['timber'] == 'on' ? 1 : 0) : 0;
        $freeData['timber_free_tropical'] = isset($params['timber_free_tropical']) ? ($params['timber_free_tropical'] == '' ? null : $params['timber_free_tropical']) : null;
        $freeData['timber_load_tropical'] = isset($params['timber_load_tropical']) ? ($params['timber_load_tropical'] == '' ? null : $params['timber_load_tropical']) : null;
        $freeData['timber_free_summer'] = isset($params['timber_free_summer']) ? ($params['timber_free_summer'] == '' ? null : $params['timber_free_summer']) : null;
        $freeData['timber_load_summer'] = isset($params['timber_load_summer']) ? ($params['timber_load_summer'] == '' ? null : $params['timber_load_summer']) : null;
        $freeData['timber_free_winter'] = isset($params['timber_free_winter']) ? ($params['timber_free_winter'] == '' ? null : $params['timber_free_winter']) : null;
        $freeData['timber_load_winter'] = isset($params['timber_load_winter']) ? ($params['timber_load_winter'] == '' ? null : $params['timber_load_winter']) : null;
        $freeData['timber_free_winteratlantic'] = isset($params['timber_free_winteratlantic']) ? ($params['timber_free_winteratlantic'] == '' ? null : $params['timber_free_winteratlantic']) : null;
        $freeData['timber_load_winteratlantic'] = isset($params['timber_load_winteratlantic']) ? ($params['timber_load_winteratlantic'] == '' ? null : $params['timber_load_winteratlantic']) : null;
        $freeData['timber_free_fw'] = isset($params['timber_free_fw']) ? ($params['timber_free_fw'] == '' ? null : $params['timber_free_fw']) : null;
        $freeData['deck_line_amount'] = isset($params['deck_line_amount']) ? ($params['deck_line_amount'] == '' ? null : $params['deck_line_amount']) : null;
        $freeData['deck_line_content'] = $params['deck_line_content'] ?? null;
        $freeData->save();

        return true;
        //	    } catch (\Exception $exception) {
//    		return false;
//	    }
    }

    public function saveShipMachineryData($params, $shipId)
    {
        //try {
        if ($shipId > 0) {
            $shipData = ShipRegister::find($shipId);
        } else {
            $shipData = new ShipRegister();
        }

        $shipData['No_TypeOfEngine'] = $params['No_TypeOfEngine'];
        $shipData['Cylinder_Bore_Stroke'] = $params['Cylinder_Bore_Stroke'];
        $shipData['Power'] = $params['Power'];
        $shipData['rpm'] = $params['rpm'];
        $shipData['EngineManufacturer'] = $params['EngineManufacturer'];
        $shipData['AddressEngMaker'] = $params['AddressEngMaker'];
        $shipData['EngineDate'] = $params['EngineDate'];
        $shipData['Speed'] = $params['Speed'] == null ? 0 : $params['Speed'];
        $shipData['PrimeMover'] = $params['PrimeMover'];
        $shipData['GeneratorOutput'] = $params['GeneratorOutput'];
        $shipData['Boiler'] = $params['Boiler'];
        $shipData['BoilerPressure'] = $params['BoilerPressure'];
        $shipData['BoilerManufacturer'] = $params['BoilerManufacturer'];
        $shipData['AddressBoilerMaker'] = $params['AddressBoilerMaker'];
        $shipData['BoilerDate'] = $params['BoilerDate'];
        $shipData['FOSailCons_S'] = $params['FOSailCons_S'] == null ? 0 : $params['FOSailCons_S'];
        $shipData['FOL/DCons_S'] = $params['FOL/DCons_S'] == null ? 0 : $params['FOL/DCons_S'];
        $shipData['FOIdleCons_S'] = $params['FOIdleCons_S'] == null ? 0 : $params['FOIdleCons_S'];
        $shipData['DOSailCons_S'] = $params['DOSailCons_S'] == null ? 0 : $params['DOSailCons_S'];
        $shipData['DOL/DCons_S'] = $params['DOL/DCons_S'] == null ? 0 : $params['DOL/DCons_S'];
        $shipData['DOIdleCons_S'] = $params['DOIdleCons_S'] == null ? 0 : $params['DOIdleCons_S'];
        $shipData['LOSailCons_S'] = $params['LOSailCons_S'] == null ? 0 : $params['LOSailCons_S'];
        $shipData['LOL/DCons_S'] = $params['LOL/DCons_S'] == null ? 0 : $params['LOL/DCons_S'];
        $shipData['LOIdleCons_S'] = $params['LOIdleCons_S'] == null ? 0 : $params['LOIdleCons_S'];
        $shipData['FOSailCons_W'] = $params['FOSailCons_W'] == null ? 0 : $params['FOSailCons_W'];
        $shipData['FOL/DCons_W'] = $params['FOL/DCons_W'] == null ? 0 : $params['FOL/DCons_W'];
        $shipData['FOIdleCons_W'] = $params['FOIdleCons_W'] == null ? 0 : $params['FOIdleCons_W'];
        $shipData['DOSailCons_W'] = $params['DOSailCons_W'] == null ? 0 : $params['DOSailCons_W'];
        $shipData['DOL/DCons_W'] = $params['DOL/DCons_W'] == null ? 0 : $params['DOL/DCons_W'];
        $shipData['DOIdleCons_W'] = $params['DOIdleCons_W'] == null ? 0 : $params['DOIdleCons_W'];
        $shipData['LOSailCons_W'] = $params['LOSailCons_W'] == null ? 0 : $params['LOSailCons_W'];
        $shipData['LOL/DCons_W'] = $params['LOL/DCons_W'] == null ? 0 : $params['LOL/DCons_W'];
        $shipData['LOIdleCons_W'] = $params['LOIdleCons_W'] == null ? 0 : $params['LOIdleCons_W'];
        $shipData->save();

        return true;
        //} catch (\Exception $exception) {
        //	return false;
        //}
    }

    public function saveShipRemarksData($params, $shipId)
    {
        //try {
        if ($shipId > 0) {
            $shipData = ShipRegister::find($shipId);
        } else {
            $shipData = new ShipRegister();
        }

        $shipData['Remarks'] = $params['Remarks'];
        $shipData->save();

        return true;
        //} catch(\Exception $exception) {
        //	return false;
        //}
    }

    public function deleteShipData(Request $request)
    {
        $dataId = $request->get('dataId');
        $shipData = ShipRegister::find($dataId);
        if (null === $shipData) {
            return -1;
        }
        $shipData->delete();

        return 1;
    }

    public function loadShipTypePage()
    {
        $list = ShipType::all();

        return view('shipManage.ship_type', ['list' => $list]);
    }

    public function loadShipTypeData()
    {
        $list = ShipType::all();

        return response()->json($list);
    }

    public function loadShipTypeModifyPage(Request $request)
    {
        $typeId = $request->get('typeId') * 1;
        if ($typeId > 0) {
            $type = ShipType::find($typeId);
        } else {
            $type = new ShipType();
        }

        return view('shipManage.ship_type_setting', ['type' => $type]);
    }

    public function dynamicList(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $params = $request->all();
        $shipName = '';

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            $firstShipInfo = $shipList[0];
            if ($firstShipInfo == null && $firstShipInfo == false) {
                return redirect()->back();
            }

            $shipId = $firstShipInfo->IMO_No;
        }

        if (isset($params['year'])) {
            $year = $params['year'];
        } else {
            $year = -1;
        }

        $voyId = '';
        if (isset($params['voyNo']) && isset($params['voyNo']) != '' && isset($params['voyNo']) != 0) {
            $voyId = $params['voyNo'];
            if ($year == -1) {
                $year = substr(date('Y'), 0, 2) . substr($voyId, 0, 2);
            }
        }

        if (isset($params['type'])) {
            $record_type = $params['type'];
        } else {
            $record_type = 'all';
        }

        $shipInfo = ShipRegister::where('IMO_No', $shipId)->first();
        if ($shipInfo == null || $shipInfo == false) {
            return redirect()->back();
        }

        $shipName = $shipInfo->shipName_En;

        $tbl = new VoyLog();
        $yearList = $tbl->getYearList($shipId);

        return view('shipManage.dynamic_list', [
            'shipList' => $shipList,
            'shipInfo' => $shipInfo,
            'shipId' => $shipId,
            'shipName' => $shipName,
            'years' => $yearList,
            'activeYear' => $yearList[0],
            'voyId' => $voyId,
            'record_type' => $record_type,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function ctmAnalytics(Request $request)
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
        $shipId = $request->get('shipId');
        $shipNameInfo = null;
        if (isset($shipId)) {
            $shipNameInfo = ShipRegister::where('IMO_No', $shipId)->first();
        } else {
            $shipNameInfo = ShipRegister::orderBy('id')->first();
            $shipId = $shipNameInfo['IMO_No'];
        }

        $ctmTbl = new Ctm();
        $yearList = $ctmTbl->getYearList($shipId);

        if (isset($params['year']) && $params['year'] != '') {
            $activeYear = $params['year'];
        } else {
            $activeYear = $yearList[0];
        }

        if (isset($params['type']) && $params['type'] != '') {
            $type = $params['type'];
        } else {
            $type = 'total';
        }

        return view('shipManage.ctm_analytics', [
            'shipList' => $shipList,
            'shipName' => $shipNameInfo,
            'shipId' => $shipId,
            'yearList' => $yearList,

            'activeYear' => $activeYear,
            'type' => $type,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function voyEvaluation(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $params = $request->all();
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            if (count($shipList) > 0) {
                $shipId = $shipList[0]->IMO_No;
            } else {
                return redirect()->back();
            }
        }

        $shipInfo = ShipRegister::where('IMO_No', $shipId)->first();
        if ($shipInfo == null) {
            $shipName = '';
        } else {
            $shipName = $shipInfo->Nick_Name != '' ? $shipInfo->Nick_Name : $shipInfo->shipName_En;
        }

        $cpList = CP::where('Ship_ID', $shipId)->orderBy('Voy_No', 'desc')->get();
        if (isset($params['voyId'])) {
            $voyId = $params['voyId'];
        } else {
            if (count($cpList) > 0) {
                $voyId = $cpList[0]->Voy_No;
            } else {
                $voyId = 0;
            }
        }
        $yearList = CP::getYearList($shipId);

        if (isset($params['type'])) {
            $type = $params['type'];
        } else {
            $type = 'main';
        }

        if (isset($params['year'])) {
            $year = $params['year'];
        } else {
            $year = $yearList[0];
        }

        return view('shipManage.voy_evaluation', [
            'shipList' => $shipList,
            'shipId' => $shipId,
            'shipInfo' => $shipInfo,
            'shipName' => $shipName,

            'cpList' => $cpList,
            'voyId' => $voyId,

            'yearList' => $yearList,
            'year' => $year,
            'breadCrumb' => $breadCrumb,
            'type' => $type,
        ]);
    }

    public function shipDataTabPage(Request $request)
    {
        $shipId = $request->get('shipId');
        $tabName = $request->get('tabName');

        if (null === $shipId) {
            $shipId = 0;
        }

        $shipInfo = ShipRegister::find($shipId);
        if ($tabName == '#general') {
            $shipList = Ship::all();
            $shipType = ShipType::all();

            return view('shipManage.tab_general', ['shipList' => $shipList, 'shipType' => $shipType, 'shipInfo' => $shipInfo]);
        } elseif ($tabName == '#hull') {
            $freeBoard = ShipFreeBoard::where('shipId', $shipId)->first();

            return view('shipManage.tab_hull', ['shipInfo' => $shipInfo, 'freeBoard' => $freeBoard]);
        } elseif ($tabName == '#machiery') {
            return view('shipManage.tab_machinery', ['shipInfo' => $shipInfo]);
        } elseif ($tabName == '#remarks') {
            return view('shipManage.tab_remarks', ['shipInfo' => $shipInfo]);
        }
    }

    public function saveShipMaterialList(Request $request)
    {
        $params = $request->all();

        if (!isset($params['id'])) {
            return redirect()->back();
        }

        $ids = $params['id'];
        if (isset($params['select_year']) || $params['select_year'] != '') {
            $year = $params['select_year'];
        } else {
            $year = null;
        }

        foreach ($ids as $key => $item) {
            if (!isset($params['category_id'][$key]) || $params['category_id'][$key] == '') {
                continue;
            }
            if (!isset($params['type_id'][$key]) || $params['type_id'][$key] == '') {
                continue;
            }
            $shipCertTbl = new ShipMaterialRegistry();
            if ($item != '' && $item > 0) {
                $shipCertTbl = ShipMaterialRegistry::find($item);
            }

            $shipCertTbl['ship_id'] = $params['ship_id'];
            $shipCertTbl['category_id'] = $params['category_id'][$key] ?? 1;
            $shipCertTbl['type_id'] = $params['type_id'][$key] ?? 1;
            $shipCertTbl['name'] = $params['name'][$key] ?? '';
            $shipCertTbl['qty'] = $params['qty'][$key] ?? null;
            $shipCertTbl['model_mark'] = $params['model_mark'][$key] ?? '';
            $shipCertTbl['sn'] = $params['sn'][$key] ?? '';
            $shipCertTbl['particular'] = $params['particular'][$key] ?? '';
            $shipCertTbl['manufacturer'] = $params['manufacturer'][$key] ?? '';

            if (isset($params['blt_year'][$key]) && $params['blt_year'][$key] != '' && $params['blt_year'][$key] != EMPTY_DATE) {
                $shipCertTbl['blt_year'] = $params['blt_year'][$key];
            } else {
                $shipCertTbl['blt_year'] = null;
            }

            $shipCertTbl['year'] = $year;
            $shipCertTbl['remark'] = $params['remark'][$key] ?? '';

            $shipCertTbl->save();
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipRegList = ShipRegister::getShipForHolder();
        } else {
            $shipRegList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        }
        $shipId = $params['ship_id'];
        if (!isset($shipId)) {
            $shipId = $shipRegList[0]->IMO_No;
        }

        return redirect('shipManage/shipMaterialList?id=' . $shipId . '&year=' . $year);
    }

    public function shipMaterialList(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipRegList = ShipRegister::getShipForHolder();
        } else {
            $shipRegList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        }

        $shipId = $request->get('id');
        $year = $request->get('year');
        $shipNameInfo = null;
        if (isset($shipId)) {
            $shipNameInfo = ShipRegister::where('RegStatus', '!=', 3)->where('IMO_No', $shipId)->first();
        } else {
            $shipNameInfo = $shipRegList[0];
            $shipId = $shipNameInfo['IMO_No'];
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            if (!in_array($shipId, $ids)) {
                $shipId = null;
                $shipNameInfo = null;
            }
        }

        //$start_year = ShipMaterialRegistry::select(DB::raw('MIN(year) as min_date'))->first();
        //$start_year = ShipRegister::where('RegStatus', '!=', 3)->select(DB::raw('MIN(RegDate) as min_date'))->first();
        if ($shipNameInfo == null) {
            $start_year = '2020';
        } else {
            $start_year = $shipNameInfo['RegDate'];
            $start_year = substr($start_year, 0, 4);
        }

        if (!isset($year)) {
            $year = date('Y');
        }

        return view('shipManage.ship_material_registry', [
            'shipList' => $shipRegList,
            'shipName' => $shipNameInfo,
            'shipId' => $shipId,
            'start_year' => $start_year,
            'year' => $year,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function shipMaterialManage(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipRegList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipRegList = ShipRegister::orderBy('id')->get();
        }

        $shipId = $request->get('id');
        $year = $request->get('year');
        $shipNameInfo = null;
        if (isset($shipId)) {
            $shipNameInfo = ShipRegister::where('IMO_No', $shipId)->first();
        } else {
            $shipNameInfo = $shipRegList[0];
            $shipId = $shipNameInfo['IMO_No'];
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            if (!in_array($shipId, $ids)) {
                $shipId = null;
                $shipNameInfo = null;
            }
        }
        /*
        $selector = ShipMaterialRegistry::whereRaw(DB::raw('LENGTH(blt_year) > 3'));
        $selector = $selector->whereRaw(DB::raw('SUBSTRING(blt_year, 1, 4) > 1900'));
        $selector = $selector->selectRaw('SUBSTRING(blt_year,1,4) as start_year');
        $record = $selector->orderBy('start_year')->first();
        if (empty($record)) {
            $start_year = date('Y');
        } else {
            $start_year = $record->start_year;
        }
        */

        /*
        $start_year = ShipMaterialRegistry::select(DB::raw('MIN(year) as min_date'))->first();
        if(empty($start_year)) {
            $start_year = '2020';
        } else {
            $start_year = substr($start_year['min_date'],0,4);
        }
        */
        if ($shipNameInfo == null) {
            $start_year = '2020';
        } else {
            $start_year = $shipNameInfo['RegDate'];
            $start_year = substr($start_year, 0, 4);
        }

        $materialCategory = ShipMaterialCategory::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();
        $materialType = ShipMaterialSubKind::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();

        if (!isset($year)) {
            $year = date('Y');
        }

        return view('shipManage.ship_material_list', [
            'shipList' => $shipRegList,
            'shipName' => $shipNameInfo,
            'shipId' => $shipId,
            'start_year' => $start_year,
            'year' => $year,
            'category' => $materialCategory,
            'type' => $materialType,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function shipCertList(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipRegList = ShipRegister::getShipForHolder();
        } else {
            $shipRegList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        }

        $shipId = $request->get('id');
        $shipNameInfo = null;
        if (isset($shipId)) {
            $shipNameInfo = ShipRegister::where('RegStatus', '!=', 3)->where('IMO_No', $shipId)->first();
        } else {
            //$shipNameInfo = ShipRegister::orderBy('id')->first();
            $shipNameInfo = $shipRegList[0];
            $shipId = $shipNameInfo['IMO_No'];
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            if (!in_array($shipId, $ids)) {
                $shipId = null;
                $shipNameInfo = null;
            }
        }

        $certType = ShipCertList::all();
        $certList = ShipCertRegistry::where('ship_id', $shipId)->get();

        return view('shipManage.ship_cert_registry', [
            'shipList' => $shipRegList,
            'shipName' => $shipNameInfo,
            'shipId' => $shipId,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function saveShipCertList(Request $request)
    {
        $params = $request->all();

        if (!isset($params['id'])) {
            return redirect()->back();
        }

        $ids = $params['id'];
        foreach ($ids as $key => $item) {
            if (!isset($params['cert_id'][$key]) || $params['cert_id'][$key] == '') {
                continue;
            }
            $shipCertTbl = new ShipCertRegistry();
            if ($item != '' && $item > 0) {
                $shipCertTbl = ShipCertRegistry::find($item);
            }

            $shipCertTbl['ship_id'] = $params['ship_id'];
            $shipCertTbl['cert_id'] = $params['cert_id'][$key] ?? 1;
            if (isset($params['issue_date'][$key]) && $params['issue_date'][$key] != '' && $params['issue_date'][$key] != EMPTY_DATE) {
                $shipCertTbl['issue_date'] = $params['issue_date'][$key];
            } else {
                $shipCertTbl['issue_date'] = null;
            }

            if (isset($params['expire_date'][$key]) && $params['expire_date'][$key] != '' && $params['expire_date'][$key] != EMPTY_DATE) {
                $shipCertTbl['expire_date'] = $params['expire_date'][$key];
            } else {
                $shipCertTbl['expire_date'] = null;
            }

            if (isset($params['due_endorse'][$key]) && $params['due_endorse'][$key] != '' && $params['due_endorse'][$key] != EMPTY_DATE) {
                $shipCertTbl['due_endorse'] = $params['due_endorse'][$key];
            } else {
                $shipCertTbl['due_endorse'] = null;
            }

            $shipCertTbl['issuer'] = $params['issuer'][$key] ?? '';
            $shipCertTbl['remark'] = $params['remark'][$key] ?? '';

            // Attachment Upload
            if ($params['is_update'][$key] == IS_FILE_UPDATE) {
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment')[$key];
                    $fileName = $file->getClientOriginalName();
                    $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/shipCertList/', $name);
                    if ($shipCertTbl['attachment'] != '' && $shipCertTbl['attachment'] != null) {
                        if (file_exists($shipCertTbl['attachment'])) {
                            @unlink($shipCertTbl['attachment']);
                        }
                    }

                    $shipCertTbl['attachment'] = public_path('/shipCertList/') . $name;
                    $shipCertTbl['attachment_link'] = '/shipCertList/' . $name;
                    $shipCertTbl['file_name'] = $fileName;
                }
            } elseif ($params['is_update'][$key] == IS_FILE_DELETE) {
                $shipCertTbl['attachment'] = null;
                $shipCertTbl['attachment_link'] = null;
                $shipCertTbl['file_name'] = null;
            }

            $shipCertTbl->save();
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipRegList = ShipRegister::getShipForHolder();
        } else {
            $shipRegList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        }
        $shipId = $params['ship_id'];
        if (!isset($shipId)) {
            $shipId = $shipRegList[0]->IMO_No;
        }

        return redirect('shipManage/shipCertList?id=' . $shipId);
    }

    public function saveShipEquipList(Request $request)
    {
        $params = $request->all();

        if (!isset($params['id'])) {
            return redirect()->back();
        }

        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            return redirect()->back();
        }

        if (isset($params['_type'])) {
            $type = $params['_type'];
        } else {
            $type = '';
        }

        $ids = $params['id'];

        foreach ($ids as $key => $id) {
            $equipTbl = new ShipEquipment();
            if (isset($id) && $id != '') {
                $equipTbl = ShipEquipment::find($id);
            }

            $equipTbl['shipId'] = $shipId;
            $equipTbl['request_date'] = $params['request_date'][$key];
            $equipTbl['supply_date'] = $params['supply_date'][$key];
            $equipTbl['place'] = $params['place'][$key];
            $equipTbl['type'] = $params['type'][$key];
            $equipTbl['item'] = $params['item'][$key];
            $equipTbl['issa_no'] = $params['issa_no'][$key];
            $equipTbl['inventory_vol'] = _convertStr2Int($params['inventory_vol'][$key]);
            $equipTbl['request_vol'] = _convertStr2Int($params['request_vol'][$key]);
            $equipTbl['supply_vol'] = _convertStr2Int($params['supply_vol'][$key]);
            $equipTbl['unit'] = $params['unit'][$key];
            $equipTbl['remark'] = $params['remark'][$key];
            $equipTbl->save();
        }

        return redirect('shipManage/equipment?id=' . $shipId . '&type=' . $type);
    }

    public function saveShipReqEquipList(Request $request)
    {
        $params = $request->all();

        if (!isset($params['id'])) {
            return redirect()->back();
        }

        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            return redirect()->back();
        }

        if (isset($params['_type'])) {
            $type = $params['_type'];
        } else {
            $type = '';
        }

        $ids = $params['id'];

        foreach ($ids as $key => $id) {
            $equipTbl = new ShipEquipmentRequire();
            if (isset($id) && $id != '') {
                $equipTbl = ShipEquipmentRequire::find($id);
            }

            $equipTbl['shipId'] = $shipId;
            $equipTbl['place'] = $params['place'][$key];
            $equipTbl['item'] = $params['item'][$key];
            $equipTbl['inventory_vol'] = _convertStr2Int($params['inventory_vol'][$key]);
            $equipTbl['require_vol'] = _convertStr2Int($params['require_vol'][$key]);
            $equipTbl['unit'] = $params['unit'][$key];
            $equipTbl['status'] = $params['status'][$key];
            $equipTbl['remark'] = $params['remark'][$key];
            $equipTbl->save();
        }

        return redirect('shipManage/equipment?id=' . $shipId . '&type=' . $type);
    }

    public function saveShipReqEquipType(Request $request)
    {
        $params = $request->all();

        $cert_ids = $params['id'];
        foreach ($cert_ids as $key => $item) {
            $certTbl = new ShipEquipmentRequireKind();
            if ($item != '' && $item != null) {
                $certTbl = ShipEquipmentRequireKind::find($item);
            }

            if ($params['order_no'][$key] != '' && $params['name'][$key] != '') {
                $certTbl['order_no'] = $params['order_no'][$key];
                $certTbl['name'] = $params['name'][$key];

                $certTbl->save();
            }
        }

        $retVal = ShipEquipmentRequireKind::all();

        return response()->json($retVal);
    }

    public function saveShipCertType(Request $request)
    {
        $params = $request->all();

        $cert_ids = $params['id'];
        foreach ($cert_ids as $key => $item) {
            $certTbl = new ShipCertList();
            if ($item != '' && $item != null) {
                $certTbl = ShipCertList::find($item);
            }

            if ($params['order_no'][$key] != '' && $params['code'][$key] != '' && $params['name'][$key] != '') {
                $certTbl['order_no'] = $params['order_no'][$key];
                $certTbl['code'] = $params['code'][$key];
                $certTbl['name'] = $params['name'][$key];

                $certTbl->save();
            }
        }

        $retVal = ShipCertList::all();

        return response()->json($retVal);
    }

    public function saveShipMaterialType(Request $request)
    {
        $params = $request->all();

        $cert_ids = $params['id'];
        foreach ($cert_ids as $key => $item) {
            $certTbl = new ShipMaterialSubKind();
            if ($item != '' && $item != null) {
                $certTbl = ShipMaterialSubKind::find($item);
            }

            if ($params['order_no'][$key] != '' && $params['name'][$key] != '') {
                $certTbl['order_no'] = $params['order_no'][$key];
                $certTbl['name'] = $params['name'][$key];

                $certTbl->save();
            }
        }

        $retVal = ShipMaterialSubKind::all();

        return response()->json($retVal);
    }

    public function saveShipMaterialCategory(Request $request)
    {
        $params = $request->all();

        $cert_ids = $params['id'];
        foreach ($cert_ids as $key => $item) {
            $certTbl = new ShipMaterialCategory();
            if ($item != '' && $item != null) {
                $certTbl = ShipMaterialCategory::find($item);
            }

            if ($params['order_no'][$key] != '' && $params['name'][$key] != '') {
                $certTbl['order_no'] = $params['order_no'][$key];
                $certTbl['name'] = $params['name'][$key];

                $certTbl->save();
            }
        }

        $retVal = ShipMaterialCategory::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();

        return response()->json($retVal);
    }

    public function getShipCertInfo(Request $request)
    {
        $shipId = $request->get('shipId');
        $certId = $request->get('certId') * 1;

        if ($certId == 0) {
            $certInfo = new ShipCertRegistry();
            $certInfo['ShipName'] = $shipId;
        } else {
            $certInfo = ShipCertRegistry::find($certId);
        }

        if (!empty($certInfo)) {
            $cert = ShipCertList::where('CertNo', $certInfo['CertNo'])->first();
            $certInfo['CertName_Cn'] = $cert['CertName_Cn'];
        }
        $certType = ShipCertList::query()->orderBy('CertNo')->get();

        return view('shipManage.ship_cert_modify', ['info' => $certInfo, 'certList' => $certType]);
    }

    public function updateCertInfo(Request $request)
    {
        $certId = $request->get('id');
        $shipName = $request->get('ShipName');
        $certName = $request->get('certName');
        $issuUnit = $request->get('issuUnit');
        $expireMonth = $request->get('expireMonth');

        $file = $request->file('copy-photo');
        $photoPath = '';

        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $photoPath = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/ship-cert'), $photoPath);
        }

        if (empty($certId)) {
            $certInfo = new ShipCertRegistry();
            $shipInfo = ShipRegister::where('RegStatus', '!=', 3)->where('RegNo', $shipName)->first();
            $certInfo['ShipName'] = $shipInfo['RegNo'];
        } else {
            $certInfo = ShipCertRegistry::find($certId);
        }

        $certInfo['CertNo'] = $request->get('CertNo');
        $certInfo['IssuedAdmin_Cn'] = $request->get('IssuedAdmin_Cn');
        $certInfo['IssuedAdmin_En'] = $request->get('IssuedAdmin_En');
        $certInfo['CertLevel'] = $request->get('CertLevel');
        $certInfo['IssuedDate'] = $request->get('IssuedDate');
        if (empty($request->get('IssuedDate'))) {
            $certInfo['IssuedDate'] = null;
        }
        $certInfo['ExpiredDate'] = $request->get('ExpiredDate');
        if (empty($request->get('ExpiredDate'))) {
            $certInfo['ExpiredDate'] = null;
        }

        $certInfo['Remark'] = $request->get('Remark');
        if (!empty($photoPath)) {
            $certInfo['Scan'] = $photoPath;
        }

        $certInfo->save();

        return redirect('shipManage/shipCertList?shipId=' . $shipName . '&certName=' . $certName . '&issuUnit=' . $issuUnit . '&expireMonth=' . $expireMonth);
    }

    public function deleteShipCert(Request $request)
    {
        $certId = $request->get('certId');
        $certInfo = ShipCertRegistry::find($certId);
        if (null === $certInfo) {
            return -1;
        }

        $certInfo->delete();

        return 1;
    }

    public function shipCertManage(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolderWithDelete();
        } else {
            $shipList = ShipRegister::orderBy('id')->get();
        }

        $shipId = $request->get('id');
        $shipNameInfo = null;
        if (isset($shipId)) {
            //$shipNameInfo = ShipRegister::getShipFullNameByRegNo($shipId);
            //$shipNameInfo = ShipRegister::find($shipId);
            $shipNameInfo = ShipRegister::where('IMO_No', $shipId)->first();
        } else {
            $shipNameInfo = $shipList[0];
            $shipId = $shipNameInfo['IMO_No'];
        }

        return view('shipManage.ship_cert_list', [
            'shipList' => $shipList,
            'shipName' => $shipNameInfo,
            'shipId' => $shipId,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function shipCertExcel(Request $request)
    {
        $shipId = $request->get('id');
        $shipName = '';
        if (isset($shipId)) {
            $retVal = ShipCertRegistry::where('ship_id', $shipId)->get();
            $shipName = ShipRegister::where('RegStatus', '!=', 3)->where('IMO_No', $shipId)->first()->shipName_En;
        } else {
            return redirect()->back();
        }

        $certTypeList = ShipCertList::all();
        foreach ($retVal as $key => $item) {
            foreach ($certTypeList as $cert) {
                if ($item->cert_id == $cert->id) {
                    $retVal[$key]->order_no = $cert->order_no;
                    $retVal[$key]->code = $cert->code;
                    $retVal[$key]->cert_name = $cert->name;

                    break;
                }
            }
        }

        return view('shipManage.ship_cert_list_excel', [
            'list' => $retVal,
            'shipName' => $shipName,
            'certList' => $certTypeList,
            'excel_name' => $shipName . '_船舶证书_' . date('Ymd'),
        ]);
    }

    public function getCertType(Request $request)
    {
        $certId = $request->get('certId') * 1;

        if ($certId == 0) {
            $certInfo = new ShipCertList();
        } else {
            $certInfo = ShipCertList::find($certId);
        }

        return view('shipManage.cert_modify', ['info' => $certInfo]);
    }

    public function updateCertType(Request $request)
    {
        $certId = $request->get('id');
        $cert = $request->get('cert');
        if (empty($certId)) {
            $certInfo = new ShipCertList();
        } else {
            $certInfo = ShipCertList::find($certId);
        }

        $certInfo['CertNo'] = $request->get('CertNo');
        $certInfo['CertName_Cn'] = $request->get('CertName_Cn');
        $certInfo['CertName_En'] = $request->get('CertName_En');

        $isExist = ShipCertList::where('CertNo', $certInfo['CertNo'])->orWhere('CertName_Cn', $certInfo['CertName_Cn'])->orWhere('CertName_En', $certInfo['CertName_En'])->first();

        if (isset($isExist) && ($isExist['id'] != $certId)) {
            $error = '错误!  做成的船舶证书已经登记了。';

            return back()->with(['error' => $error]);
        }
        $certInfo['CertKind'] = $request->get('CertKind');
        $certInfo['Details'] = $request->get('Details');
        $certInfo->save();

        return redirect('shipManage/shipCertManage?cert=' . $cert);
    }

    public function deleteShipCertType(Request $request)
    {
        $certId = $request->get('certId');
        $certInfo = ShipCertList::find($certId);
        if (null === $certInfo) {
            return -1;
        }

        $certInfo->delete();

        return 1;
    }

    public function fuelManage(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $params = $request->all();
        $shipName = '';
        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            $firstShipInfo = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->first();
            if ($firstShipInfo == null && $firstShipInfo == false) {
                return redirect()->back();
            }

            $shipId = $firstShipInfo->IMO_No;
        }

        $shipInfo = ShipRegister::where('RegStatus', '!=', 3)->where('IMO_No', $shipId)->first();
        if ($shipInfo == null || $shipInfo == false) {
            return redirect()->back();
        }

        $shipName = $shipInfo->shipName_En;

        $tbl = new VoyLog();
        $yearList = $tbl->getYearList($shipId);

        if (isset($params['year'])) {
            $year = $params['year'];
        } else {
            $year = $yearList[0];
        }

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            if (!in_array($shipId, $ids)) {
                $shipId = null;
                $shipName = null;
            }
            $shipList = ShipRegister::getShipForHolder();
        } else {
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
        }

        return view('shipManage.fuel_manage', [
            'shipList' => $shipList,
            'shipInfo' => $shipInfo,
            'shipId' => $shipId,
            'shipName' => $shipName,
            'years' => $yearList,
            'activeYear' => $year,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function shipEquipmentManage(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            $shipList = ShipRegister::getShipForHolder();
        } else {
            $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();
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

        if (isset($params['type'])) {
            $type = $params['type'];
        } else {
            $type = 'record';
        }

        $shipName = $shipRegTbl->getShipNameByIMO($shipId);

        $tbl = new ShipEquipment();
        $yearList = $tbl->getYearList($shipId);

        if (isset($params['year'])) {
            $activeYear = $params['year'];
        } else {
            $activeYear = $yearList[0];
        }

        return view('shipManage.ship_equipment', [
            'shipList' => $shipList,
            'shipId' => $shipId,
            'shipName' => $shipName,

            'years' => $yearList,
            'activeYear' => $activeYear,

            'type' => $type,
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function shipEquepmentByKind(Request $request)
    {
        $kindId = $request->get('kindId');
        $shipId = $request->get('shipId');
        $equipmentName = $request->get('keyword');
        $params = json_decode($request['params'], true);

        $shipEquipTbl = new ShipEquipment();
        $equipmentList = $shipEquipTbl->getShipEquipList($shipId, $params);

        foreach ($equipmentList as $key => $value) {
            $equipmentList[$key] = _objectToArray($value);
        }

        $kindList = [];
        $mainKind = ShipEquipmentMainKind::all();
        foreach ($mainKind as $key => $item) {
            $kindList[$item['id']] = $item['Kind_Cn'];
        }

        return view('shipManage.ship_equipment_table', [
            'list' => $equipmentList,
            'shipId' => $shipId,
            'kindLabelList' => $kindList,
        ]);
    }

    public function appendNewShipEquipment(Request $request)
    {
//        $equipId = $request->get('equipId');
        $mainKind = $request->get('mainKind');
        $id = $request->get('id');
        $subKind = 1;
        $name_cn = $request->get('Euipment_Cn');
        $name_en = $request->get('Euipment_En');
        $shipId = $request->get('shipId');

        if (isset($id)) {
            $equipment = ShipEquipment::find($id);
        } else {
            $equipment = new ShipEquipment();
        }

        $equipment['KindOfEuipmentId'] = $mainKind;
        $equipment['ShipRegNo'] = $shipId;
//        $equipment['PIC'] = $request->get('PIC');
        $equipment['Euipment_Cn'] = $request->get('Euipment_Cn');
        $equipment['Euipment_En'] = $request->get('Euipment_En');
        $equipment['Label'] = $request->get('Label');
        $equipment['Type'] = $request->get('Type');
        $equipment['SN'] = $request->get('SN');
        $equipment['IssaCodeNo'] = $request->get('IssaCodeNo');
        $equipment['Qty'] = $request->get('Qty');
        $equipment['Unit'] = $request->get('Unit');
//        $equipment['ManufactureDate'] = $request->get('ManufactureDate');
        $equipment['Remark'] = $request->get('Remark');
        $equipment->save();

        if (!isset($equipId)) {
            return redirect('shipManage/shipEquipmentManage?shipId=' . $shipId);
        }

        $last = ShipEquipment::all()->last('id');
        $lastId = $last['id'];

        return redirect('shipManage/getEquipmentDetail?equipId=' . $lastId);
    }

    public function appendNewShipDiligenceEquipment(Request $request)
    {
        $mainKind = $request->get('mainKind');
        $subKind = 1;
        $name_cn = $request->get('Euipment_Cn');
        $name_en = $request->get('Euipment_En');
        $shipId = $request->get('shipId');
        $id = $request->get('id');

        if (isset($id)) {
            $equipment = ShipDiligence::find($id);
        } else {
            $equipment = new ShipDiligence();
        }

        $equipment['KindOfEuipmentId'] = $mainKind;
        $equipment['ShipRegNo'] = $shipId;
        $equipment['remain_count'] = $request->get('remain_count');
        $equipment['Euipment_Cn'] = $request->get('Euipment_Cn');
        $equipment['Euipment_En'] = $request->get('Euipment_En');
        $equipment['Label'] = $request->get('Label');
        $equipment['Type'] = $request->get('Type');
        $equipment['SN'] = $request->get('SN');
        $equipment['IssaCodeNo'] = $request->get('IssaCodeNo');
        $equipment['remain_count'] = $request->get('remain_count');
        $equipment['Unit'] = $request->get('Unit');
        $equipment['Status'] = $request->get('Status');
        $equipment['diligence_at'] = $request->get('diligenceDate');
        $equipment['Remark'] = $request->get('Remark');
        $equipment->save();

        if (!isset($equipId)) {
            return redirect('shipManage/shipEquipmentManage?shipId=' . $shipId);
        }

        $last = ShipEquipment::all()->last('id');
        $lastId = $last['id'];

        return redirect('shipManage/getEquipmentDetail?equipId=' . $lastId);
    }

    public function deleteShipEquipment(Request $request)
    {
        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        if ($type == 'supply') {
            $device = ShipEquipment::find($deviceId);
        } else {
            $device = ShipDiligence::find($deviceId);
        }

        if (null === $device) {
            return -1;
        }

        $device->delete();

        return $deviceId;
    }

    public function shipSubEquipemntList(Request $request)
    {
        $kindId = $request->get('mainKind');
        $subKinds = ShipEquipmentSubKind::where('Kind', $kindId)->orderBy('id')->get();

        $optionHtml = '';
        foreach ($subKinds as $kind) {
            $optionHtml .= '<option value="' . $kind['id'] . '">' . $kind['GroupOfEuipment_Cn'] . '</option>';
        }

        return $optionHtml;
    }

    public function getEquipmentDetail(Request $request)
    {
        $GLOBALS['selMenu'] = 54;
        $GLOBALS['submenu'] = 107;

        $deviceId = $request->get('equipId');
        $device = ShipEquipment::find($deviceId);

        $parts = ShipEquipmentPart::loadEquipmentParts($deviceId);
        $partPaginate = Util::makePaginateHtml(0, 0, $parts);
        $propertys = ShipEquipmentProperty::where('EuipmentID', $deviceId)->paginate(100)->setPath('');
        $propertyPaginate = Util::makePaginateHtml(0, 0, $propertys);
        $units = EquipmentUnit::all();

        $shipId = $request->get('shipId');
        if (isset($shipId)) {
            $shipName = ShipRegister::getShipFullNameByRegNo($shipId);
        }

        $kindInfo = ShipEquipmentRegKind::find($device['KindOfEuipmentId']);

        $allMainKind = ShipEquipmentMainKind::all();
        $allSubKind = ShipEquipmentSubKind::select('id', 'GroupOfEuipment_Cn')
            ->where('Kind', $kindInfo['KindId'])
            ->get();
        $list = ShipIssaCodeNo::getAllItems('', '', '', '');

        if ($request->ajax()) {
            return view(
                'shipManage.ship_equipment_detail',
                ['deviceId' => $deviceId,
                    'parts' => $parts,
                    'propertys' => $propertys,
                    'deviceName' => $device['Euipment_Cn'],
                    'partPaginate' => $partPaginate,
                    'propertyPaginate' => $propertyPaginate,
                ]
            );
        }

        return view(
            'shipManage.ship_equipment_modify',
            ['parts' => $parts,
                'propertys' => $propertys,
                'kindInfo' => $kindInfo,
                'mainKinds' => $allMainKind,
                'subKinds' => $allSubKind,
                'device' => $device,
                'shipId' => $shipId,
                'shipName' => $shipName,
                'units' => $units,
                'partPaginate' => $partPaginate,
                'propertyPaginate' => $propertyPaginate,
                'list' => $list,
            ]
        );
    }

    public function getSupplyHistory(Request $request)
    {
        $params = $request->all();
        $shipId = $params['shipId'];
        $equipName = $params['equipName'];
        $issa_code = $params['issa_code'];

        $supplyList = ShipEquipment::select('tb_ship_equipment.*')
            ->where('tb_ship_equipment.ShipRegNo', $shipId)
            ->where('tb_ship_equipment.IssaCodeNo', $issa_code)
            ->where('tb_ship_equipment.supplied_at', '!=', '')
            ->orderBy('tb_ship_equipment.supplied_at', 'desc')
            ->orderBy('tb_ship_equipment.created_at', 'desc')
            ->get();

        $diligenceList = ShipDiligence::select('tb_ship_equipment_diligence.*')
            ->where('tb_ship_equipment_diligence.ShipRegNo', $shipId)
            ->where('tb_ship_equipment_diligence.IssaCodeNo', $issa_code)
            ->orderBy('tb_ship_equipment_diligence.diligence_at', 'desc')
            ->orderBy('tb_ship_equipment_diligence.created_at', 'desc')
            ->get();

        $mainKind = ShipEquipmentMainKind::all();
        foreach ($mainKind as $key => $item) {
            $kindList[$item['id']] = $item['Kind_Cn'];
        }

        return view(
            'shipManage.ship_equipment_detail',
            ['equipName' => $equipName,
                'registeredList' => $supplyList,
                'diligenceList' => $diligenceList,
                'kindLabelList' => $kindList,
                'shipId' => $shipId,
            ]
        );
    }

    public function getDiligenceDetail(Request $request)
    {
        $params = $request->all();
        if (!isset($params['equipId'])) {
            return redirect()->back();
        }
        $device = ShipDiligence::find($params['equipId']);
        $allMainKind = ShipEquipmentMainKind::all();
        $shipName = ShipRegister::getShipFullNameByRegNo($params['shipId']);

        return view(
            'shipManage.ship_diligence_equipment_modify',
            ['mainKinds' => $allMainKind,
                'device' => $device,
                'shipId' => $params['shipId'],
                'shipName' => $shipName,
                //				    'units'         =>  $units,
                //				    'partPaginate'  =>  $partPaginate,
                //				    'propertyPaginate'=>$propertyPaginate,
                //				    'list'          =>  $list
            ]
        );
    }

    public function propertyTableEquipmentByDeviceID(Request $request)
    {
        $deviceId = $request->get('equipId');

        $propertys = ShipEquipmentProperty::where('EuipmentID', $deviceId)->paginate(5)->setPath('');
        $propertyPaginate = Util::makePaginateHtml(0, 0, $propertys);

        return view(
            'shipManage.equipment_property_table',
            ['deviceId' => $deviceId,
                'propertys' => $propertys,
                'propertyPaginate' => $propertyPaginate,
            ]
        );
    }

    public function partTableEquipmentByDeviceID(Request $request)
    {
        $deviceId = $request->get('equipId');

        $parts = ShipEquipmentPart::loadEquipmentParts($deviceId);
        $partPaginate = Util::makePaginateHtml(0, 0, $parts);

        return view(
            'shipManage.equipment_part_table',
            ['deviceId' => $deviceId,
                'parts' => $parts,
                'partPaginate' => $partPaginate,
            ]
        );
    }

    public function propertyTabEquipmentByDeviceID(Request $request)
    {
        $deviceId = $request->get('equipId');

        $propertys = ShipEquipmentProperty::where('EuipmentID', $deviceId)->paginate(5)->setPath('');
        $propertyPaginate = Util::makePaginateHtml(0, 0, $propertys);

        return view(
            'shipManage.equipment_property_tab',
            [
                'propertys' => $propertys,
                'propertyPaginate' => $propertyPaginate,
            ]
        );
    }

    public function partTabEquipmentByDeviceID(Request $request)
    {
        $deviceId = $request->get('equipId');

        $parts = ShipEquipmentPart::loadEquipmentParts($deviceId);
        $partPaginate = Util::makePaginateHtml(0, 0, $parts);
        $units = EquipmentUnit::all();

        return view(
            'shipManage.equipment_part_tab',
            [
                'parts' => $parts,
                'partPaginate' => $partPaginate,
                'units' => $units,
            ]
        );
    }

    public function updateEquipmentProperty(Request $request)
    {
        $propertyId = $request->get('id');
        if (isset($propertyId)) {
            $property = ShipEquipmentProperty::find($propertyId);
        } else {
            $property = new ShipEquipmentProperty();
            $property['EuipmentID'] = $request->get('equipId');
        }

        $property['Items_Cn'] = $request->get('Items_Cn');
        $property['Items_En'] = $request->get('Items_En');

        $isExist = ShipEquipmentProperty::where('Items_Cn', $property['Items_Cn'])->where('Items_En', $property['Items_En'])->first();
        if (isset($isExist) && ($propertyId != $isExist['id'])) {
            return -1;
        }

        $property['Particular'] = $request->get('Particular');
        $property['Remark'] = $request->get('Remark');
        $property->save();

        return 1;
    }

    public function deleteEquipmentProperty(Request $request)
    {
        $propertyId = $request->get('propertyId');
        $property = ShipEquipmentProperty::find($propertyId);
        if (null === $property) {
            return -1;
        }

        $property->delete();

        return 1;
    }

    public function updateEquipmentPart(Request $request)
    {
        $partId = $request->get('id');
        if (isset($partId)) {
            $part = ShipEquipmentPart::find($partId);
        } else {
            $part = new ShipEquipmentPart();
            $part['EuipmentID'] = $request->get('equipId');
        }

        $part['PartName_Cn'] = $request->get('PartName_Cn');
        $part['PartName_En'] = $request->get('PartName_En');

        $isExist = ShipEquipmentPart::where('PartName_Cn', $part['PartName_Cn'])->where('PartName_En', $part['PartName_En'])->first();
        if (isset($isExist) && ($partId != $isExist['id'])) {
            return -1;
        }

        $part['Special'] = $request->get('Special');
        $part['PartNo'] = $request->get('PartNo');
        $part['IssaCodeNo'] = $request->get('IssaCodeNo');
        $part['Unit'] = $request->get('Unit');
        $part['Qtty'] = $request->get('Qtty');
        $part['Remark'] = $request->get('Remark');
        $part->save();
        $lastId = ShipEquipmentPart::all(['id'])->last();

        return $lastId['id'];
    }

    public function deleteEquipmentPart(Request $request)
    {
        $partId = $request->get('partId');
        $part = ShipEquipmentPart::find($partId);
        if (null === $part) {
            return -1;
        }

        $part->delete();

        return 1;
    }

    public function equipmentTypeManage(Request $request)
    {
        Util::getMenuInfo($request);

        $mainKind = ShipEquipmentMainKind::all();
        $subKind = ShipEquipmentSubKind::all();
        foreach ($subKind as $kind) {
            $kindId = $kind['Kind'];
            $kindInfo = ShipEquipmentMainKind::find($kindId);
            $kind['kind_name'] = $kindInfo['Kind_Cn'];
        }

        $unitsList = ShipEquipmentUnits::all();

        return view('shipManage.equipment_type_manage', ['mainKind' => $mainKind, 'subKind' => $subKind, 'unitsList' => $unitsList]);
    }

    public function updateEquipmentType(Request $request)
    {
        $typeId = $request->get('main_type_id') * 1;
        if ($typeId == 0) {
            $type = new ShipEquipmentMainKind();
        } else {
            $type = ShipEquipmentMainKind::find($typeId);
        }

        $type['Kind_Cn'] = $request->get('type_name');
        $type['Kind_En'] = $request->get('type_name_en');
        $type['Remark'] = $request->get('type_descript');
        $type->save();

        return back();
    }

    public function UpdateMainEquipment(Request $request)
    {
        $equipId = $request->get('equip_id') * 1;
        if ($equipId == 0) {
            $equipment = new ShipEquipmentSubKind();
        } else {
            $equipment = ShipEquipmentSubKind::find($equipId);
        }

        $equipment['GroupOfEuipment_Cn'] = $request->get('sub_name_Cn');
        $equipment['GroupOfEuipment_En'] = $request->get('sub_name_en');
        $equipment['Kind'] = $request->get('main_type');
        $remark = $request->get('sub_type_remark');
        if (empty($remark)) {
            $remark = null;
        }
        $equipment['Remark'] = $remark;
        if (null === $equipment['order']) {
            $count = ShipEquipmentSubKind::where('Kind', $equipment['Kind'])->count() + 1;
            $countStr = sprintf('%02s', $count . '');
            $kindStr = sprintf('%02s', $equipment['Kind']);
            $equipment['order'] = $kindStr . '-' . $countStr;
        }

        $equipment->save();

        return back();
    }

    public function UpdateEquipmentUnits(Request $request)
    {
        $unitId = $request->get('unit_id') * 1;
        if ($unitId == 0) {
            $equipment = new ShipEquipmentUnits();
        } else {
            $equipment = ShipEquipmentUnits::find($unitId);
        }

        $equipment['unit_cn'] = $request->get('unit_cn');
        $equipment['unit_en'] = $request->get('unit_en');
        $equipment['remark'] = $request->get('remark');
        $equipment->save();

        return back();
    }

    public function deleteEquipmentMainType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipEquipmentMainKind::find($typeId);
        if (null === $type) {
            return -1;
        }
        $type->delete();

        return 1;
    }

    public function deleteEquipmentSubType(Request $request)
    {
        $kindId = $request->get('kindId');
        $kind = ShipEquipmentSubKind::find($kindId);
        if (null === $kind) {
            return -1;
        }

        $kind->delete();

        return 1;
    }

    public function deleteEquipmentUnits(Request $request)
    {
        $unitId = $request->get('unit_id');
        $units = ShipEquipmentUNits::find($unitId);
        if (null === $units) {
            return -1;
        }

        $units->delete();

        return 1;
    }

    public function shipISSACodeManage(Request $request)
    {
        Util::getMenuInfo($request);

        $code = $request->get('code');
        $codeNo = $request->get('codeNo');
        $content = $request->get('content');

        $list = ShipIssaCodeNo::getAllItems($code, $codeNo, $content, 10);

        if (isset($code)) {
            $list->appends(['code' => $code]);
        }
        if (isset($codeNo)) {
            $list->appends(['codeNo' => $codeNo]);
        }
        if (isset($content)) {
            $list->appends(['content' => $content]);
        }

        $codeList = ShipIssaCode::all();

        return view('shipManage.ship_issacode_manage', ['list' => $list, 'codeList' => $codeList, 'code' => $code, 'codeNo' => $codeNo, 'content' => $content]);
    }

    public function updateIssaCode(Request $request)
    {
        $codeId = $request->get('codeId');
        if (empty($codeId)) {
            $code = new ShipIssaCodeNo();
        } else {
            $code = ShipIssaCodeNo::find($codeId);
        }

        $code['Code'] = $request->get('sel_type');
        $code['CodeNo'] = $request->get('CodeNo');
        $code['Content_Cn'] = $request->get('Content_Cn');
        $code['Content_En'] = $request->get('Content_En');
        $code['Capacity'] = $request->get('Capacity');
        $code->save();

        return back();
    }

    public function deleteIssaCode(Request $request)
    {
        $codeId = $request->get('codeId');
        $code = ShipIssaCodeNo::find($codeId);
        if (null === $code) {
            return -1;
        }

        $code->delete();

        return 1;
    }

    public function shipNameManage(Request $request)
    {
        Util::getMenuInfo($request);
        $shipnames = Ship::getAllItem();
        $error = Session::get('error');

        return view('shipManage.ship_name_manage', ['list' => $shipnames, 'error' => $error]);
    }

    public function deleteOriginShip(Request $request)
    {
        $shipId = $request->get('shipId');
        $ship = Ship::find($shipId);
        if (null === $ship) {
            return -1;
        }

        $ship->delete();

        return 1;
    }

    public function registerShipOrigin(Request $request)
    {
        $shipId = $request->get('shipId');
        $ship = Ship::find($shipId);
        if (null === $ship) {
            $ship = new Ship();
        }

        $ship['name'] = $request->get('origin_name');
        $ship['shipNo'] = $request->get('shipNo');
        $isExist = Ship::where('name', $ship['name'])->orWhere('shipNo', $ship['shipNo'])->first();
        if (isset($isExist) && ($shipId != $isExist['id'])) {
            $error = $ship['name'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $ship['person_num'] = $request->get('ship-person');
        $ship->save();

        return back();
    }

    public function shipPositionManage(Request $request)
    {
        Util::getMenuInfo($request);

        $posName = $request->get('name');
        $list = ShipPosition::getShipPositionList($posName);
        $error = Session::get('error');

        return view('shipManage.ship_position_manage', ['list' => $list, 'posName' => $posName, 'error' => $error]);
    }

    public function deleteShipPosition(Request $request)
    {
        $posId = $request->get('posId');
        $position = ShipPosition::find($posId);
        if (null === $position) {
            return -1;
        }

        $position->delete();

        return 1;
    }

    public function registerShipPosition(Request $request)
    {
        $posId = $request->get('posId');
        $position = ShipPosition::find($posId);
        if (null === $position) {
            $position = new ShipPosition();
        }

        $position['Duty'] = $request->get('Duty');
        $position['Duty_En'] = $request->get('Duty_En');
        $isExist = ShipPosition::where('Duty', $position['Duty'])->orWhere('Duty_En', $position['Duty_En'])->first();
        if (isset($isExist) && ($posId != $isExist['id'])) {
            $error = $position['Duty'] . ' 职务是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $position['Description'] = $request->get('pos_descript');
        $position->save();

        return back();
    }

    public function shipTypeManage(Request $request)
    {
        Util::getMenuInfo($request);
        $list = ShipType::orderBy('ShipType_Cn')->get();
        $error = Session::get('error');

        return view('shipManage.ship_type_manage', ['list' => $list, 'error' => $error]);
    }

    public function deleteShipType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipType::find($typeId);
        if (null === $type) {
            return -1;
        }

        $type->delete();

        return 1;
    }

    public function registerShipType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipType::find($typeId);
        if (null === $type) {
            $type = new ShipType();
        }

        $type['ShipType_Cn'] = $request->get('ShipType_Cn');
        $type['ShipType'] = $request->get('ShipType');

        $isExist = ShipType::where('ShipType_Cn', $type['ShipType_Cn'])->orWhere('ShipType', $type['ShipType'])->first();
        if (isset($isExist) && ($typeId != $isExist['id'])) {
            $error = $type['ShipType_Cn'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $type->save();

        return back();
    }

    public function shipISSACodeType(Request $request)
    {
        Util::getMenuInfo($request);
        $list = ShipIssaCode::orderBy('Code_Cn')->get();
        $error = Session::get('error');

        return view('shipManage.ship_issacode_type', ['list' => $list, 'error' => $error]);
    }

    public function deleteISSACodeType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipIssaCode::find($typeId);
        if (null === $type) {
            return -1;
        }

        $type->delete();

        return 1;
    }

    public function registerISSACodeType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipIssaCode::find($typeId);
        if (null === $type) {
            $type = new ShipIssaCode();
        }

        $type['Code'] = $request->get('Code');
        $type['Code_Cn'] = $request->get('Code_Cn');

        $isExist = ShipIssaCode::where('Code', $type['Code'])->orWhere('Code_Cn', $type['Code_Cn'])->first();
        if (isset($isExist) && ($typeId != $isExist['id'])) {
            $error = $type['Code_Cn'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $type['Code_En'] = $request->get('Code_En');
        $type['Details'] = $request->get('Details');
        $type->save();

        return back();
    }

    public function shipSTCWManage(Request $request)
    {
        Util::getMenuInfo($request);
        $list = ShipSTCWCode::getCodeList();
        $typeList = ShipTrainingCourse::all();
        $error = Session::get('error');

        return view('shipManage.ship_stcw_type', ['list' => $list, 'typeList' => $typeList, 'error' => $error]);
    }

    public function deleteSTCWType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipSTCWCode::find($typeId);
        if (null === $type) {
            return -1;
        }

        $type->delete();

        return 1;
    }

    public function registerSTCWType(Request $request)
    {
        $typeId = $request->get('typeId');
        $type = ShipSTCWCode::find($typeId);
        if (null === $type) {
            $type = new ShipSTCWCode();
        }

        $type['STCWRegCode'] = $request->get('STCWRegCode');
        $type['Contents'] = $request->get('Contents');

        $isExist = ShipSTCWCode::where('STCWRegCode', $type['STCWRegCode'])->orWhere('Contents', $type['Contents'])->first();
        if (isset($isExist) && ($typeId != $isExist['id'])) {
            $error = $type['Contents'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $type['Contents_En'] = $request->get('Contents_En');
        $type['TrainingCourseID'] = $request->get('TrainingCourseID');
        $type->save();

        return back();
    }

    public function memberCapacityManage(Request $request)
    {
        Util::getMenuInfo($request);
        $STCWCodes = ShipSTCWCode::all();
        $list = ShipMemberCapacity::getData();

        return view('shipManage.member_capacity_manage', ['list' => $list, 'STCWCodes' => $STCWCodes]);
    }

    public function registerMemberCapacity(Request $request)
    {
        $capacityId = $request->get('capacityId');
        $capacity = ShipMemberCapacity::find($capacityId);
        if (null === $capacity) {
            $capacity = new ShipMemberCapacity();
        }

        $capacity['Capacity'] = $request->get('capacity_Cn');
        $capacity['Capacity_En'] = $request->get('capacity_en');

        $isExist = ShipMemberCapacity::where('Capacity', $capacity['Capacity'])->orWhere('Capacity_En', $capacity['Capacity_En'])->first();
        if (isset($isExist) && ($capacityId != $isExist['id'])) {
            $error = $capacity['Capacity'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }

        $capacity['STCWRegID'] = $request->get('STCWRegID');
        $capacity['Grade'] = $request->get('grade');
        $capacity['Remarks'] = $request->get('remarks');
        $capacity['Gen_Remarks'] = $request->get('gen_remarks');
        $capacity->save();

        return back();
    }

    public function deleteMemberCapacity(Request $request)
    {
        $capacityId = $request->get('capacityId');
        $capacity = ShipMemberCapacity::find($capacityId);
        if (null === $capacity) {
            return -1;
        }

        $capacity->delete();

        return 1;
    }

    public function shipOthersManage(Request $request)
    {
        Util::getMenuInfo($request);

        $list = ShipOthers::all();

        return view('shipManage.ship_others_manage', ['list' => $list]);
    }

    public function registerShipOthers(Request $request)
    {
        $othersId = $request->get('typeId');
        $others = ShipOthers::find($othersId);
        if (null === $others) {
            $others = new ShipOthers();
        }

        $others['Others_Cn'] = $request->get('Others_Cn');
        $others['Others_En'] = $request->get('Others_En');

        $isExist = ShipOthers::where('Others_Cn', $others['Others_Cn'])
            ->orWhere('Others_En', $others['Others_En'])
            ->first();

        if (isset($isExist) && ($othersId != $isExist['OthersId'])) {
            $error = $others['Others_Cn'] . ' 是已经被登记了。';

            return back()->with(['error' => $error]);
        }
        $others['Special'] = $request->get('Special');
        $others['Remark'] = $request->get('Remark');
        $others->save();

        return back();
    }

    public function deleteShipOthers(Request $request)
    {
        $othersId = $request->get('OthersId');
        $others = ShipOthers::find($othersId);
        if (null === $others) {
            return -1;
        }

        $others->delete();

        return 1;
    }

    public function shipPartManage(Request $request)
    {
        Util::getMenuInfo($request);

        $list = ShipOthers::orderBy('Others_Cn')->OrderBy('Special')->get();

        return view('shipManage.part_manage', ['list' => $list]);
    }

    public function ajaxSupplyDateUpdate(Request $request)
    {
        $params = $request->all();

        $equipId = $params['id'];
        $supplyDate = $params['date'];

        $shipEquipment = ShipEquipment::find($equipId);
        $shipEquipment['supplied_at'] = $supplyDate;
        $shipEquipment->save();

        return response()->json(1);
    }

    public function getShipGeneralInfo($del = false)
    {
        $user_pos = Auth::user()->pos;
        if ($user_pos == STAFF_LEVEL_SHAREHOLDER || $user_pos == STAFF_LEVEL_CAPTAIN) {
            //$shipList = ShipRegister::getShipForHolder();
            $ids = Auth::user()->shipList;
            $ids = explode(',', $ids);
            if ($del) {
                $ship_infolist = ShipRegister::where('RegStatus', '!=', 3)->whereIn('IMO_No', $ids);
            } else {
                $ship_infolist = ShipRegister::whereIn('IMO_No', $ids);
            }
            $ship_infolist = $ship_infolist
                ->select('tb_ship_register.*', 'tb_ship.name', 'tb_ship.shipNo', 'tb_ship.person_num', 'tb_ship_type.ShipType_Cn', 'tb_ship_type.ShipType', DB::raw('IFNULL(tb_ship.id, 100) as num'))
                ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
                ->leftJoin('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
                ->orderByRaw("FIELD(RegStatus , '2', '1', '3') ASC")
                ->orderBy('id')
                ->get();
        } else {
            if ($del) {
                $ship_infolist = ShipRegister::select('tb_ship_register.*', 'tb_ship.name', 'tb_ship.shipNo', 'tb_ship.person_num', 'tb_ship_type.ShipType_Cn', 'tb_ship_type.ShipType', DB::raw('IFNULL(tb_ship.id, 100) as num'))
                    ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
                    ->leftJoin('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
                    ->orderByRaw("FIELD(RegStatus , '2', '1', '3') ASC")
                    ->orderBy('id')
                    ->get();
            } else {
                $ship_infolist = ShipRegister::where('RegStatus', '!=', 3)->select('tb_ship_register.*', 'tb_ship.name', 'tb_ship.shipNo', 'tb_ship.person_num', 'tb_ship_type.ShipType_Cn', 'tb_ship_type.ShipType', DB::raw('IFNULL(tb_ship.id, 100) as num'))
                    ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
                    ->leftJoin('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
                    ->orderByRaw("FIELD(RegStatus , '2', '1', '3') ASC")
                    ->orderBy('id')
                    ->get();
            }
        }

        foreach ($ship_infolist as $info) {
            $query = "SELECT COUNT(*) AS navi_count, member.personSum FROM tb_ship_member
                        LEFT JOIN ( SELECT RegNo, SUM(PersonNum) AS personSum FROM tb_ship_msmcdata WHERE RegNo = '" . $info['RegNo'] . "') AS member
                        ON  tb_ship_member.ShipId = member.RegNo
                        WHERE ShipId = '" . $info->RegNo . "'";
            $result = DB::select($query);
            if (count($result) > 0) {
                $result = $result[0];
            }
            $info['navi_count'] = $result->navi_count;
            $info['personSum'] = $result->personSum;
        }

        return $ship_infolist;
    }

    public function ajaxShipMaterialList(Request $request)
    {
        $params = $request->all();
        $id = $params['ship_id'];
        $year = $params['year'] ?? 0;
        $category = $params['category'] ?? 0;
        $type = $params['type'] ?? 0;

        $selector = ShipMaterialRegistry::orderBy('id', 'asc')->select('*');
        if ($id != 0) {
            $selector = $selector->where('ship_id', $id);
        }

        if ($year != 0) {
            $selector = $selector->where('year', $year);
        }

        if ($category != 0) {
            $selector = $selector->where('category_id', $category);
        }

        if ($type != 0) {
            $selector = $selector->where('type_id', $type);
        }

        $retVal['ship'] = $selector->get();
        /*
        if($id == 0)
            $retVal['ship'] = ShipMaterialRegistry::all();
        else {
            $retVal['ship'] = ShipMaterialRegistry::where('ship_id', $id)->orderBy('id', 'asc')->get();
        }
        */

        $retVal['material_category'] = ShipMaterialCategory::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();
        $retVal['material_type'] = ShipMaterialSubKind::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();

        $retVal['ship_id'] = $id;
        $retVal['ship_name'] = ShipRegister::where('RegStatus', '!=', 3)->where('IMO_No', $id)->first()->shipName_En;

        return response()->json($retVal);
    }

    public function ajaxShipCertList(Request $request)
    {
        $params = $request->all();
        $id = $params['ship_id'];

        if ($id == 0) {
            $retVal['ship'] = ShipCertRegistry::all();
        } else {
            $retVal['ship'] = ShipCertRegistry::where('ship_id', $id)->orderBy('cert_id', 'asc')->get();
        }

        $shipCertRegTbl = new ShipCertRegistry();
        if (isset($params['expire_date']) && $params['expire_date'] > 0) {
            $retVal['ship'] = $shipCertRegTbl->getExpiredList($params['expire_date'], $id);
        }

        $retVal['cert_type'] = ShipCertList::all();

        $retVal['ship_id'] = $params['ship_id'];
        $retVal['ship_name'] = ShipRegister::where('IMO_No', $id)->first()->shipName_En;

        return response()->json($retVal);
    }

    public function ajaxCertAdd(Request $request)
    {
        $params = $request->all();

        $order_no = $params['order_no'];
        $code = $params['code'];
        $name = $params['name'];

        $certTbl = new ShipCertList();

        $certTbl['order_no'] = $order_no;
        $certTbl['code'] = $code;
        $certTbl['name'] = $name;

        $certTbl->save();

        $retVal = ShipCertList::all();

        return response()->json($retVal);
    }

    public function ajaxCertItemDelete(Request $request)
    {
        $params = $request->all();
        $selector = ShipCertRegistry::where('cert_id', $params['id']);
        $records = $selector->first();
        if (!empty($records)) {
            $ret = 0;

            return response()->json($ret);
        }
        ShipCertList::where('id', $params['id'])->delete();
        $retVal = ShipCertList::all();

        return response()->json($retVal);
    }

    public function ajaxMaterialCategoryItemDelete(Request $request)
    {
        $params = $request->all();
        $selector = ShipMaterialRegistry::where('category_id', $params['id']);
        $records = $selector->first();
        if (!empty($records)) {
            $ret = 0;

            return response()->json($ret);
        }

        ShipMaterialCategory::where('id', $params['id'])->delete();
        $retVal = ShipMaterialCategory::orderByRaw('CAST(order_no AS SIGNED) ASC')->get();

        return response()->json($retVal);
    }

    public function ajaxMaterialTypeItemDelete(Request $request)
    {
        $params = $request->all();
        $selector = ShipMaterialRegistry::where('type_id', $params['id']);
        $records = $selector->first();
        if (!empty($records)) {
            $ret = 0;

            return response()->json($ret);
        }

        ShipMaterialSubKind::where('id', $params['id'])->delete();
        $retVal = ShipMaterialSubKind::all();

        return response()->json($retVal);
    }

    public function ajaxShipMaterialDelete(Request $request)
    {
        $params = $request->all();

        ShipMaterialRegistry::where('id', $params['id'])->delete();

        return response()->json(1);
    }

    public function ajaxShipCertDelete(Request $request)
    {
        $params = $request->all();

        ShipCertRegistry::where('id', $params['id'])->delete();

        return response()->json(1);
    }

    public function ajaxCtmTotal(Request $request)
    {
        $params = $request->all();

        $shipId = $params['shipId'];
        $year = $params['year'];

        $ctmTbl = new Ctm();
        $retVal['current'] = $ctmTbl->getCtmTotal($shipId, $year);

        $prevTbl = Ctm::where('shipId', $shipId)->orderBy('reg_date', 'desc')->orderBy('ctm_no', 'desc');
        $prevTbl2 = Ctm::where('shipId', $shipId)->orderBy('reg_date', 'desc')->orderBy('ctm_no', 'desc');
        $prevTbl->whereRaw(DB::raw('mid(reg_date, 1, 4) < ' . $year));
        $prevTbl2->whereRaw(DB::raw('mid(reg_date, 1, 4) < ' . $year));

        $cnyTbl = $prevTbl->where('ctm_type', CNY_LABEL)->first();
        $usdTbl = $prevTbl2->where('ctm_type', USD_LABEL)->first();

        $retVal['before']['cny'] = $cnyTbl;
        $retVal['before']['usd'] = $usdTbl;

        return response()->json($retVal);
    }

    public function ajaxCtmDebit(Request $request)
    {
        $params = $request->all();

        $shipId = $params['shipId'];
        $year = $params['year'];

        $ctmTbl = new Ctm();
        $retVal = $ctmTbl->getCtmDebit($shipId, $year);

        return response()->json($retVal);
    }

    public function ajaxCtmDebits(Request $request)
    {
        $params = $request->all();
        $year = $params['year'];
        $shipIds = $params['shipId'];
        $result = [];
        $ctmTbl = new Ctm();
        foreach ($shipIds as $shipId) {
            $retVal = $ctmTbl->getCtmDebit($shipId, $year);
            $result[$shipId] = $retVal;
        }

        return response()->json($result);
    }

    public function ajaxDynamicSearch(Request $request)
    {
        $params = $request->all();

        if (isset($params['shipId'])) {
            $shipId = $params['shipId'];
        } else {
            return redirect()->back();
        }

        $year = $params['year'];
        if (isset($params['year'])) {
            $params['year'] = substr($params['year'], 2, 2);
        }

        $cpList = CP::where('ship_ID', $shipId)->whereRaw(DB::raw('mid(Voy_No, 1, 2) like ' . $params['year']))->orderBy('Voy_No', 'asc')->get();

        $tbl = new VoyLog();
        foreach ($cpList as $key => $item) {
            $voyId = $item->Voy_No;
            $fuelList = Fuel::where('shipId', $shipId)->where('voy_no', $voyId)->first();

            $cpInfo = CP::where('ship_ID', $shipId)->where('Voy_No', $voyId)->first();

            if ($cpInfo == null) {
                $retVal['cpData'][$voyId] = [];
            } else {
                $retVal['cpData'][$voyId] = $cpInfo;
            }

            if ($fuelList == null) {
                $beforeVoy = $tbl->getBeforeInfo($shipId, $voyId);
                $firstVoy = VoyLog::where('CP_ID', $voyId)->where('Ship_ID', $shipId)->orderBy('Voy_Date', 'asc')->orderBy('Voy_Hour', 'asc')->orderBy('Voy_Minute', 'asc')->orderBy('GMT', 'asc')->orderBy('id', 'asc')->first();

                $mainInfo = VoyLog::where('Ship_ID', $shipId)
                    ->where('CP_ID', $voyId)
                    ->orderBy('Voy_Date', 'asc')
                    ->orderBy('Voy_Hour', 'asc')
                    ->orderBy('Voy_Minute', 'asc')
                    ->orderBy('GMT', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                if (isset($mainInfo) && count($mainInfo) > 0) {
                    $retVal['currentData'][$voyId]['main'] = $mainInfo;
                    $retVal['currentData'][$voyId]['before'] = ($beforeVoy == [] ? $firstVoy : $beforeVoy);
                    $retVal['currentData'][$voyId]['is_exist'] = false;

                    $decideTbl = new DecisionReport();
                    $debit_credit = $decideTbl->getIncome($shipId, $voyId);
                    $oil_fee = $debit_credit[2][OUTCOME_FEE2] ?? 0;
                    $retVal['currentData'][$voyId]['fuelSum'] = round($oil_fee, 2);
                    $retVal['voyData'][] = [$voyId, false];
                }
            } else {
                $retVal['currentData'][$voyId] = $fuelList;
                $retVal['voyData'][] = [$voyId, true];
            }
        }

        return response()->json($retVal);
    }

    public function fuelSave(Request $request)
    {
        $params = $request->all();

        if (!isset($params['shipId'])) {
            return redirect()->back();
        }

        $shipId = $params['shipId'];
        $year = $params['year'];
        $ids = $params['id'];

        // var_dump($params);die;
        foreach ($ids as $key => $id) {
            $tbl = new Fuel();
            if ($id != '') {
                $tbl = Fuel::find($id);
            }

            $tbl['shipId'] = $shipId;
            $tbl['year'] = $year;

            $tbl['voy_no'] = $params['voy_no'][$key];
            $tbl['avg_speed'] = $params['avg_speed'][$key];
            $tbl['up_rob_fo'] = _convertStr2Int($params['up_rob_fo'][$key]);
            $tbl['up_rob_do'] = _convertStr2Int($params['up_rob_do'][$key]);
            $tbl['down_rob_fo'] = _convertStr2Int($params['down_rob_fo'][$key]);
            $tbl['down_rob_do'] = _convertStr2Int($params['down_rob_do'][$key]);
            $tbl['bunk_fo'] = _convertStr2Int($params['bunk_fo'][$key]);
            $tbl['bunk_do'] = _convertStr2Int($params['bunk_do'][$key]);
            $tbl['rob_fo'] = _convertStr2Int($params['rob_fo'][$key]);
            $tbl['rob_do'] = _convertStr2Int($params['rob_do'][$key]);
            $tbl['used_fo'] = _convertStr2Int($params['used_fo'][$key]);
            $tbl['used_do'] = _convertStr2Int($params['used_do'][$key]);
            $tbl['saved_fo'] = _convertStr2Int($params['saved_fo'][$key]);
            $tbl['saved_do'] = _convertStr2Int($params['saved_do'][$key]);
            $tbl['fuelSum'] = _convertStr2Int($params['fuelSum'][$key]);
            $tbl['oil_price_fo'] = _convertStr2Int($params['oil_price_fo'][$key]);
            $tbl['oil_price_do'] = _convertStr2Int($params['oil_price_do'][$key]);
            $tbl['oil_price_else'] = _convertStr2Int($params['oil_price_else'][$key]);
            $tbl['remark'] = $params['remark'][$key];

            // Attachment Upload
            if ($params['is_up_update'][$key] == IS_FILE_UPDATE) {
                if ($request->hasFile('attachment_up')) {
                    $file = $request->file('attachment_up')[$key];
                    $fileName = $file->getClientOriginalName();
                    $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/fuelManage/', $name);

                    $tbl['is_up_attach'] = 0;
                    $tbl['attachment_url_up'] = public_path('/fuelManage/') . $name;
                    $tbl['attachment_link_up'] = '/fuelManage/' . $name;
                }
            } elseif ($params['is_up_update'][$key] == IS_FILE_DELETE) {
                $tbl['is_up_attach'] = 1;
                $tbl['attachment_url_up'] = '';
                $tbl['attachment_link_up'] = '';
            }

            if ($params['is_down_update'][$key] == IS_FILE_UPDATE) {
                if ($request->hasFile('attachment_down')) {
                    $file = $request->file('attachment_down')[$key];
                    $fileName = $file->getClientOriginalName();
                    $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/fuelManage/', $name);

                    $tbl['is_down_attach'] = 0;
                    $tbl['attachment_url_down'] = public_path('/fuelManage/') . $name;
                    $tbl['attachment_link_down'] = '/fuelManage/' . $name;
                }
            } elseif ($params['is_down_update'][$key] == IS_FILE_DELETE) {
                $tbl['is_down_attach'] = 1;
                $tbl['attachment_url_down'] = '';
                $tbl['attachment_link_down'] = '';
            }

            $tbl->save();
        }

        return redirect('/shipManage/fuelManage?shipId=' . $params['shipId'] . '&year=' . $params['year']);
    }

    public function ajaxEquipmentList(Request $request)
    {
        $params = $request->all();

        $equipTbl = new ShipEquipment();
        $record = $equipTbl->getEquipmentList($params);

        return response()->json($record);
    }

    public function ajaxShipEquipDelete(Request $request)
    {
        $params = $request->all();

        $retVal = ShipEquipment::where('id', $params['id'])->delete();

        return response()->json($retVal);
    }

    public function ajaxReqEquipmentList(Request $request)
    {
        $params = $request->all();

        $equipTbl = new ShipEquipmentRequire();
        $record = $equipTbl->getEquipmentList($params);

        return response()->json($record);
    }

    public function ajaxShipReqEquipDelete(Request $request)
    {
        $params = $request->all();

        $retVal = ShipEquipmentRequire::where('id', $params['id'])->delete();

        return response()->json($retVal);
    }

    public function ajaxShipReqEquipTypeList(Request $request)
    {
        $params = $request->all();

        $list = ShipEquipmentRequireKind::all();

        return response()->json($list);
    }

    public function ajaxShipReqEquipTypeDelete(Request $request)
    {
        $params = $request->all();

        $retVal = ShipEquipmentRequireKind::where('id', $params['id'])->delete();

        $retVal = ShipEquipmentRequireKind::all();

        return response()->json($retVal);
    }

    public function ajaxEvaluation(Request $request)
    {
        $params = $request->all();

        $shipId = $params['shipId'];
        $voyId = $params['voyId'];

        $evalTbl = new Evaluation();

        $retVal = $evalTbl->getEvaluationData($shipId, $voyId);

        return response()->json($retVal);
    }

    public function ajaxEvaluationElse(Request $request)
    {
        $params = $request->all();

        $shipId = $params['shipId'];
        $year = $params['year'];

        $voyList = CP::getCpList($shipId, $year);

        $evalTbl = new Evaluation();
        $retVal = [];
        foreach ($voyList as $key => $item) {
            $retVal[] = $evalTbl->getEvaluationData($shipId, $item->Voy_No);
        }

        return response()->json($retVal);
    }
}
