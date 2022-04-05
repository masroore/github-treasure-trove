<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/10/19
 * Time: 10:16.
 */

namespace App\Models\Convert;

use App\Models\Decision\DecisionReport;

use App\Models\Finance\ExpectedCosts;
use App\Models\Finance\ReportSave;
use App\Models\Operations\Cargo;
use App\Models\Operations\CP;
use App\Models\ShipManage\Fuel;

use App\Models\ShipManage\ShipRegister;

use App\Models\ShipTechnique\ShipPort;
use Illuminate\Database\Eloquent\Model;
use Litipk\BigNumbers\Decimal;

class VoySettle extends Model
{
    protected $table = 'tbl_voy_settle';

    protected $_DAY_UNIT = 1000 * 3600;

    public function getRealData($shipId, $voyId): void
    {
    }

    public function getTotalData($shipId, $voyId)
    {
        $voyLog = new VoyLog();
        $cpTbl = new CP();
        $cargoTbl = new Cargo();
        $portTbl = new ShipPort();
        $reportSave = new ReportSave();
        $shipInfo = ShipRegister::where('IMO_No', $shipId)->first();
        if ($shipInfo == null) {
            return false;
        }

        $beforeVoyInfo = $voyLog->getBeforeInfo($shipId, $voyId);
        $mainInfo = [];
        $elseInfo = [];
        $fuelInfo = [];
        $creditInfo = [];
        $debitInfo = [];

        $voyInfo = $voyLog->getCurrentData($shipId, $voyId);
        if ($voyInfo != []) {
            $firstVoyDate = $beforeVoyInfo;
            $lastVoyDate = $voyInfo[count($voyInfo) - 1];

            $_sailTime = 0;
            $_loadTime = 0;
            $_dischTime = 0;
            $_waitTime = 0;
            $_weatherTime = 0;
            $_repairTime = 0;
            $_supplyTime = 0;
            $_elseTime = 0;

            $_cmpltCgoQty = 0;

            $start_date = $beforeVoyInfo->Voy_Date . ' ' . $beforeVoyInfo->Voy_Hour . ':' . $beforeVoyInfo->Voy_Minute . ':00';
            $start_gmt = $beforeVoyInfo->GMT;
            $total_distance = 0;
            $departStatus = false;

            $_usedFo = 0;
            $_usedDo = 0;
            $_bunkFo = 0;
            $_bunkDo = 0;

            foreach ($voyInfo as $key => $item) {
                if ($item->Voy_Type == DYNAMIC_SUB_SALING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_sailTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_LOADING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_loadTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_DISCH) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_dischTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_WAITING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_waitTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_WEATHER) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_weatherTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_REPAIR) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_repairTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_SUPPLY) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_supplyTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_ELSE) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_elseTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Status == DYNAMIC_CMPLT_LOADING) {
                    $_cmpltCgoQty = $item->Cargo_Qtty;
                }

                if ($item->Voy_Status == DYNAMIC_DEPARTURE && !$departStatus) {
                    $elseInfo['position'] = $item->Ship_Position;
                    $elseInfo['date'] = $item->Voy_Date;
                    $elseInfo['hour'] = $item->Voy_Hour;
                    $elseInfo['minute'] = $item->Voy_Minute;
                    $elseInfo['rob_do'] = round($item->ROB_DO, 2);
                    $elseInfo['rob_fo'] = round($item->ROB_FO, 2);
                    $departStatus = true;
                }

                $_bunkDo += $item->BUNK_DO;
                $_bunkFo += $item->BUNK_FO;

                $start_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                $start_gmt = $item->GMT;

                $total_distance += $item->Sail_Distance;
            }

            $mainInfo['sail_time'] = round($_sailTime, 2);
            $mainInfo['load_time'] = round($_loadTime, 2) + round($_dischTime, 2);
            $mainInfo['disch_time'] = round($_dischTime, 2);
            $mainInfo['wait_time'] = round(round($_waitTime, 2) + round($_weatherTime, 2) + round($_repairTime, 2) + round($_supplyTime, 2) + round($_elseTime, 2), 2);

            $mainInfo['start_date'] = $firstVoyDate->Voy_Date;
            $mainInfo['start_hour'] = $firstVoyDate->Voy_Hour;
            $mainInfo['start_minute'] = $firstVoyDate->Voy_Minute;

            $mainInfo['end_date'] = $lastVoyDate->Voy_Date;
            $mainInfo['end_hour'] = $lastVoyDate->Voy_Hour;
            $mainInfo['end_minute'] = $lastVoyDate->Voy_Minute;

            $start_date = $firstVoyDate->Voy_Date . ' ' . $firstVoyDate->Voy_Hour . ':' . $firstVoyDate->Voy_Minute . ':00';
            $end_date = $lastVoyDate->Voy_Date . ' ' . $lastVoyDate->Voy_Hour . ':' . $lastVoyDate->Voy_Minute . ':00';
            $mainInfo['total_sail_time'] = round($mainInfo['sail_time'] + $mainInfo['load_time'] + $mainInfo['wait_time'], 2);
            $mainInfo['total_distance'] = round($total_distance, 0);
            if ($mainInfo['total_sail_time'] > 0 && $_sailTime != 0) {
                $mainInfo['avg_speed'] = round($total_distance / $_sailTime / 24, 1);
            } else {
                $mainInfo['avg_speed'] = 0;
            }

            // 标准消耗
            $usedFoTmp1 = round($_sailTime, 2) * $shipInfo['FOSailCons_S'];
            $usedFoTmp2 = ($_loadTime + $_dischTime) * $shipInfo['FOL/DCons_S'];
            $usedFoTmp3 = $mainInfo['wait_time'] * $shipInfo['FOIdleCons_S'];

            $usedDoTmp1 = round($_sailTime, 2) * $shipInfo['DOSailCons_S'];
            $usedDoTmp2 = ($_loadTime + $_dischTime) * $shipInfo['DOL/DCons_S'];
            $usedDoTmp3 = $mainInfo['wait_time'] * $shipInfo['DOIdleCons_S'];

            $used_fo = $usedFoTmp1 + $usedFoTmp2 + $usedFoTmp3;
            $used_do = $usedDoTmp1 + $usedDoTmp2 + $usedDoTmp3;

            $fuelInfo['used_fo'] = round($used_fo, 2);
            $fuelInfo['used_do'] = round($used_do, 2);

            $fuelInfoTbl = Fuel::where('shipId', $shipId)->where('voy_no', $voyId)->first();
            if ($fuelInfoTbl == null) {
                $fuelInfo['rob_fo_price_1'] = 0;
                $fuelInfo['rob_do_price_1'] = 0;
            } else {
                $fuelInfo['rob_fo_price_1'] = round($fuelInfoTbl->oil_price_fo, 2);
                $fuelInfo['rob_do_price_1'] = round($fuelInfoTbl->oil_price_do, 2);
            }

            // 总消耗
            if ($beforeVoyInfo == []) {
                $beforeFo = 0;
                $beforeDo = 0;
            } else {
                $beforeFo = round($beforeVoyInfo->ROB_FO, 2);
                $beforeDo = round($beforeVoyInfo->ROB_DO, 2);
            }

            if ($lastVoyDate == []) {
                $lastFo = 0;
                $lastDo = 0;
            } else {
                $lastFo = round($lastVoyDate->ROB_FO, 2);
                $lastDo = round($lastVoyDate->ROB_DO, 2);
            }

            $fuelInfo['rob_fo_1'] = round($beforeFo + $_bunkFo - $lastFo, 2);
            $fuelInfo['rob_do_1'] = round($beforeDo + $_bunkDo - $lastDo, 2);

            $fuelInfo['rob_fo_2'] = 0;
            $fuelInfo['rob_do_2'] = 0;

            // Voy Contract Info
            $contractInfo = $cpTbl->getContractInfo($shipId, $voyId);
            if ($contractInfo != []) {
                $currency = $contractInfo->currency;
                $rate = /*$currency == USD_LABEL ? 1 : ($contractInfo->rate == 0 ? 1 : $contractInfo->rate)*/ 1;
                $mainInfo['cargo_name'] = $cargoTbl->getCargoNames($contractInfo->Cargo);
                $mainInfo['voy_type'] = $contractInfo->CP_kind;

                if ($contractInfo->CP_kind == 'TC') {
                    $_cmpltCgoQty = $mainInfo['total_sail_time'];
                } else {
                    $_cmpltCgoQty = $_cmpltCgoQty;
                }

                if ($contractInfo->Freight == null || $contractInfo->Freight == 0) {
                    $mainInfo['freight_price'] = $contractInfo->total_Freight / $rate;
                } else {
                    $mainInfo['freight_price'] = $contractInfo->Freight * $_cmpltCgoQty;
                }

                $mainInfo['cgo_qty'] = $_cmpltCgoQty;
                $mainInfo['freight_price'] = round($mainInfo['freight_price'] / $rate, 2);
                $mainInfo['freight'] = $contractInfo->Freight;
                $mainInfo['freight'] = round($mainInfo['freight'] / $rate, 2);
                $mainInfo['lport'] = $portTbl->getPortNames($contractInfo->LPort);
                $mainInfo['dport'] = $portTbl->getPortNames($contractInfo->DPort);
                $mainInfo['com_fee'] = $contractInfo->com_fee;

                // $fuelInfo['rob_fo_price_1'] = round($contractInfo->fo_price, 2);
                // $fuelInfo['rob_do_price_1'] = round($contractInfo->do_price, 2);

                $fuelInfo['rob_fo_price_2'] = 0;
                $fuelInfo['rob_do_price_2'] = 0;
            } else {
                $mainInfo['cargo_name'] = '';
                $mainInfo['voy_type'] = '';
            }
        }

        $mainInfo['freight_price'] ??= 0;

        $mainInfo['com_fee'] ??= 0;

        $elseInfo['load'] = [[]];
        $elseInfo['discharge'] = [[]];
        $elseInfo['fuel'] = [[]];
        $creditInfo['rent_total'] = round($mainInfo['freight_price'], 2);
        $creditInfo['else'] = [
            [
                'name' => '运费(租金)',
                'amount' => round($mainInfo['freight_price'], 2),
                'readonly' => true,
            ],
            [],
            [],
            [],
        ];

        $debitInfo['commission'] = round($mainInfo['freight_price'] * $mainInfo['com_fee'] / 100, 2);
        $debitInfo['service_charge'] = $reportSave->getServiceAmount($shipId, $voyId);
        $debitInfo['else'] = [
            [
                'name' => '佣金',
                'amount' => $debitInfo['commission'],
                'readonly' => true,
                'is_readonly' => true,
            ],
            [
                'name' => '装货港',
                'amount' => 0,
                'readonly' => true,
                'is_readonly' => false,
            ],
            [
                'name' => '卸货港',
                'amount' => 0,
                'readonly' => true,
                'is_readonly' => false,
            ],
            [
                'name' => '耗油成本',
                'amount' => 0,
                'readonly' => true,
                'is_readonly' => true,
            ],

            [], [], [], [], [], [], ];

        return [
            'main' => $mainInfo,
            'else' => $elseInfo,
            'fuel' => $fuelInfo,
            'credit' => $creditInfo,
            'debit' => $debitInfo,
        ];
    }

    public function getData($shipId, $voyId)
    {
        $settleMain = new VoySettleMain();
        $settleElse = new VoySettleElse();
        $settleFuel = new VoySettleFuel();
        $settleProfit = new VoySettleProfit();

        $_mainInfo = VoySettleMain::where('shipId', $shipId)->where('voyId', $voyId)->first();
        if ($_mainInfo == null) {
            return false;
        }

        $_originInfo = VoySettleElse::where('shipId', $shipId)->where('voyId', $voyId)->where('type', VOY_SETTLE_ORIGIN)->first();
        if ($_originInfo == null) {
            $_originInfo = [];
        }

        $_loadInfo = VoySettleElse::where('shipId', $shipId)->where('voyId', $voyId)->where('type', VOY_SETTLE_LOAD)->get();
        if (!isset($_loadInfo) || count($_loadInfo) == 0) {
            $_loadInfo = [];
        }

        $_disInfo = VoySettleElse::where('shipId', $shipId)->where('voyId', $voyId)->where('type', VOY_SETTLE_DIS)->get();
        if (!isset($_disInfo) || count($_disInfo) == 0) {
            $_disInfo = [];
        }

        $_elseFuelInfo = VoySettleElse::where('shipId', $shipId)->where('voyId', $voyId)->where('type', VOY_SETTLE_FUEL)->get();
        if (!isset($_elseFuelInfo) || count($_elseFuelInfo) == 0) {
            $_elseFuelInfo = [];
        }

        $_fuelInfo = VoySettleFuel::where('shipId', $shipId)->where('voyId', $voyId)->first();
        if ($_fuelInfo == null) {
            return false;
        }

        $_creditInfo = VoySettleProfit::where('shipId', $shipId)->where('voyId', $voyId)->where('type', REPORT_TYPE_EVIDENCE_IN)->orderBy('id', 'asc')->get();
        if ($_creditInfo == null) {
            $_creditInfo = [];
        }

        $_debitInfo = VoySettleProfit::where('shipId', $shipId)->where('voyId', $voyId)->where('type', REPORT_TYPE_EVIDENCE_OUT)->orderBy('id', 'asc')->get();
        if ($_debitInfo == null) {
            $_debitInfo = [];
        }

        $_mainInfo['start_date'] = date('Y-m-d', strtotime($_mainInfo['load_date']));
        $_mainInfo['start_hour'] = date('H', strtotime($_mainInfo['load_date']));
        $_mainInfo['start_minute'] = date('i', strtotime($_mainInfo['load_date']));

        $_mainInfo['end_date'] = date('Y-m-d', strtotime($_mainInfo['dis_date']));
        $_mainInfo['end_hour'] = date('H', strtotime($_mainInfo['dis_date']));
        $_mainInfo['end_minute'] = date('i', strtotime($_mainInfo['dis_date']));

        $_elseInfo['id'] = $_originInfo['id'];
        $_elseInfo['position'] = $_originInfo['position'];
        $_elseInfo['date'] = $_originInfo['load_date'] == null ? '' : date('Y-m-d', strtotime($_originInfo['load_date']));
        $_elseInfo['hour'] = $_originInfo['load_date'] == null ? '' : date('H', strtotime($_originInfo['load_date']));
        $_elseInfo['minute'] = $_originInfo['load_date'] == null ? '' : date('i', strtotime($_originInfo['load_date']));
        $_elseInfo['rob_fo'] = $_originInfo['rob_fo'];
        $_elseInfo['rob_do'] = $_originInfo['rob_do'];
        $_elseInfo['load'] = $_loadInfo;
        $_elseInfo['discharge'] = $_disInfo;
        $_elseInfo['fuel'] = $_elseFuelInfo;

        foreach ($_elseInfo['load'] as $key => $item) {
            $_elseInfo['load'][$key]['arrival_hour'] = $item->arrival_date == null ? '' : date('H', strtotime($item->arrival_date));
            $_elseInfo['load'][$key]['arrival_minute'] = $item->arrival_date == null ? '' : date('i', strtotime($item->arrival_date));
            $_elseInfo['load'][$key]['arrival_date'] = $item->arrival_date == null ? '' : date('Y-m-d', strtotime($item->arrival_date));

            $_elseInfo['load'][$key]['load_hour'] = $item->load_date == null ? '' : date('H', strtotime($item->load_date));
            $_elseInfo['load'][$key]['load_minute'] = $item->load_date == null ? '' : date('i', strtotime($item->load_date));
            $_elseInfo['load'][$key]['load_date'] = $item->load_date == null ? '' : date('Y-m-d', strtotime($item->load_date));
        }

        foreach ($_elseInfo['discharge'] as $key => $item) {
            $_elseInfo['discharge'][$key]['arrival_hour'] = $item->arrival_date == null ? '' : date('H', strtotime($item->arrival_date));
            $_elseInfo['discharge'][$key]['arrival_minute'] = $item->arrival_date == null ? '' : date('i', strtotime($item->arrival_date));
            $_elseInfo['discharge'][$key]['arrival_date'] = $item->arrival_date == null ? '' : date('Y-m-d', strtotime($item->arrival_date));

            $_elseInfo['discharge'][$key]['load_hour'] = $item->load_date == null ? '' : date('H', strtotime($item->load_date));
            $_elseInfo['discharge'][$key]['load_minute'] = $item->load_date == null ? '' : date('i', strtotime($item->load_date));
            $_elseInfo['discharge'][$key]['load_date'] = $item->load_date == null ? '' : date('Y-m-d', strtotime($item->load_date));
        }
        foreach ($_elseInfo['fuel'] as $key => $item) {
            $_elseInfo['fuel'][$key]['arrival_hour'] = $item->arrival_date == null ? '' : date('H', strtotime($item->arrival_date));
            $_elseInfo['fuel'][$key]['arrival_minute'] = $item->arrival_date == null ? '' : date('i', strtotime($item->arrival_date));
            $_elseInfo['fuel'][$key]['arrival_date'] = $item->arrival_date == null ? '' : date('Y-m-d', strtotime($item->arrival_date));

            $_elseInfo['fuel'][$key]['load_hour'] = $item->load_date == null ? '' : date('H', strtotime($item->load_date));
            $_elseInfo['fuel'][$key]['load_minute'] = $item->load_date == null ? '' : date('i', strtotime($item->load_date));
            $_elseInfo['fuel'][$key]['load_date'] = $item->load_date == null ? '' : date('Y-m-d', strtotime($item->load_date));
        }

        $creditInfo['rent_total'] = null;
        $creditInfo['else'] = $_creditInfo;
        $debitInfo['else'] = $_debitInfo;

        return [
            'main' => $_mainInfo,
            'else' => $_elseInfo,
            'fuel' => $_fuelInfo,
            'credit' => $creditInfo,
            'debit' => $debitInfo,
        ];
    }

    public function getDataForEval($shipId, $voyId)
    {
        $voyLog = new VoyLog();
        $cpTbl = new CP();
        $cargoTbl = new Cargo();
        $portTbl = new ShipPort();
        $reportSave = new ReportSave();
        $shipInfo = ShipRegister::where('IMO_No', $shipId)->first();
        if ($shipInfo == null) {
            return false;
        }

        $beforeVoyInfo = $voyLog->getBeforeInfo($shipId, $voyId);
        $lastVoyInfo = $voyLog->getLastInfo($shipId, $voyId);

        $mainInfo = [];
        $elseInfo = [];
        $fuelInfo = [];
        $creditInfo = [];
        $debitInfo = [];

        $voyInfo = $voyLog->getCurrentData($shipId, $voyId);
        // $voyInfo = array_push($beforeVoyInfo, $voyInfo);
        if ($voyInfo != []) {
            $firstVoyDate = $beforeVoyInfo;
            $lastVoyDate = $voyInfo[count($voyInfo) - 1];

            $_sailTime = 0;
            $_loadTime = 0;
            $_dischTime = 0;
            $_waitTime = 0;
            $_weatherTime = 0;
            $_repairTime = 0;
            $_supplyTime = 0;
            $_elseTime = 0;

            $_cmpltCgoQty = 0;

            $start_date = $beforeVoyInfo->Voy_Date . ' ' . $beforeVoyInfo->Voy_Hour . ':' . $beforeVoyInfo->Voy_Minute . ':00';
            $start_gmt = $beforeVoyInfo->GMT;
            $total_distance = 0;
            $departStatus = false;

            $_usedFo = 0;
            $_usedDo = 0;
            $_bunkFo = 0;
            $_bunkDo = 0;

            foreach ($voyInfo as $key => $item) {
                if ($item->Voy_Type == DYNAMIC_SUB_SALING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_sailTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_LOADING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_loadTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_DISCH) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_dischTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_WAITING) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_waitTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_WEATHER) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_weatherTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_REPAIR) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_repairTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_SUPPLY) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_supplyTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Type == DYNAMIC_SUB_ELSE) {
                    $end_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                    $_elseTime += $this->getTermDay($start_date, $end_date, $start_gmt, $item->GMT);
                }

                if ($item->Voy_Status == DYNAMIC_CMPLT_LOADING) {
                    $_cmpltCgoQty = $item->Cargo_Qtty;
                }

                if ($item->Voy_Status == DYNAMIC_DEPARTURE && !$departStatus) {
                    $elseInfo['position'] = $item->Ship_Position;
                    $elseInfo['date'] = $item->Voy_Date;
                    $elseInfo['hour'] = $item->Voy_Hour;
                    $elseInfo['minute'] = $item->Voy_Minute;
                    $elseInfo['rob_do'] = round($item->ROB_DO, 2);
                    $elseInfo['rob_fo'] = round($item->ROB_FO, 2);
                    $departStatus = true;
                }

                $_bunkDo += $item->BUNK_DO;
                $_bunkFo += $item->BUNK_FO;

                $start_date = $item->Voy_Date . ' ' . $item->Voy_Hour . ':' . $item->Voy_Minute . ':00';
                $start_gmt = $item->GMT;

                $total_distance += $item->Sail_Distance;
            }

            $mainInfo['sail_time'] = round($_sailTime, 2);
            $mainInfo['load_time'] = round($_loadTime, 2);
            $mainInfo['disch_time'] = round($_dischTime, 2);
            $mainInfo['wait_time'] = round(round($_waitTime, 2) + round($_weatherTime, 2) + round($_repairTime, 2) + round($_supplyTime, 2) + round($_elseTime, 2), 2);
            $mainInfo['start_date'] = $firstVoyDate->Voy_Date;

            $mainInfo['end_date'] = $lastVoyDate->Voy_Date;

            $start_date = $firstVoyDate->Voy_Date . ' ' . $firstVoyDate->Voy_Hour . ':' . $firstVoyDate->Voy_Minute . ':00';
            $end_date = $lastVoyDate->Voy_Date . ' ' . $lastVoyDate->Voy_Hour . ':' . $lastVoyDate->Voy_Minute . ':00';
            $mainInfo['total_sail_time'] = round($mainInfo['sail_time'] + $mainInfo['load_time'] + $mainInfo['disch_time'] + $mainInfo['wait_time'], 2);
            $mainInfo['total_distance'] = round($total_distance, 0);
            if ($mainInfo['total_sail_time'] > 0 && $_sailTime != 0) {
                $mainInfo['avg_speed'] = round($total_distance / $_sailTime / 24, 2);
            } else {
                $mainInfo['avg_speed'] = 0;
            }

            // 标准消耗
            $usedFoTmp1 = $_sailTime * $shipInfo['FOSailCons_S'];
            $usedFoTmp2 = ($_loadTime + $_dischTime) * $shipInfo['FOL/DCons_S'];
            $usedFoTmp3 = $_waitTime * $shipInfo['FOIdleCons_S'];

            $usedDoTmp1 = $_sailTime * $shipInfo['DOSailCons_S'];
            $usedDoTmp2 = ($_loadTime + $_dischTime) * $shipInfo['DOL/DCons_S'];
            $usedDoTmp3 = $_waitTime * $shipInfo['DOIdleCons_S'];

            $used_fo = $usedFoTmp1 + $usedFoTmp2 + $usedFoTmp3;
            $used_do = $usedDoTmp1 + $usedDoTmp2 + $usedDoTmp3;

            $mainInfo['used_fo'] = round($used_fo, 2);
            $mainInfo['used_do'] = round($used_do, 2);

            // 总消耗
            if ($beforeVoyInfo == []) {
                $beforeFo = 0;
                $beforeDo = 0;
            } else {
                $beforeFo = $beforeVoyInfo->ROB_FO;
                $beforeDo = $beforeVoyInfo->ROB_DO;
            }

            if ($lastVoyInfo == []) {
                $lastFo = 0;
                $lastDo = 0;
            } else {
                $lastFo = $lastVoyInfo->ROB_FO;
                $lastDo = $lastVoyInfo->ROB_DO;
            }

            $fuelTbl = new Fuel();
            if ($fuelTbl->getFuelForEval($shipId, $voyId) == []) {
                $mainInfo['rob_fo'] = round($beforeFo + $_bunkFo - $lastFo, 2);
                $mainInfo['rob_do'] = round($beforeDo + $_bunkDo - $lastDo, 2);
                $mainInfo['rob_fo_price'] = 0;
                $mainInfo['rob_do_price'] = 0;
            } else {
                $info = $fuelTbl->getFuelForEval($shipId, $voyId);
                $mainInfo['rob_fo'] = $info['rob_fo'];
                $mainInfo['rob_do'] = $info['rob_do'];
                $mainInfo['rob_fo_price'] = $info['rob_fo_price'];
                $mainInfo['rob_do_price'] = $info['rob_do_price'];
            }

            $tmp1 = round($mainInfo['rob_fo'] * $mainInfo['rob_fo_price'], 2);
            $tmp2 = round($mainInfo['rob_do'] * $mainInfo['rob_do_price'], 2);
            $mainInfo['fuel_consumpt'] = round($tmp1 + $tmp2, 2);
        }

        // Voy Contract Info
        $contractInfo = $cpTbl->getContractInfo($shipId, $voyId);
        if ($contractInfo != []) {
            $currency = $contractInfo->currency;
            $rate = $currency == USD_LABEL ? 1 : ($contractInfo->rate == 0 ? 1 : $contractInfo->rate);
            $mainInfo['cargo_name'] = $cargoTbl->getCargoNames($contractInfo->Cargo);
            $mainInfo['voy_type'] = $contractInfo->CP_kind;

            if ($contractInfo->CP_kind == 'TC') {
                $_cmpltCgoQty = !isset($mainInfo['total_sail_time']) ? '' : $mainInfo['total_sail_time'];
            } else {
                $_cmpltCgoQty = !isset($_cmpltCgoQty) ? '' : $_cmpltCgoQty;
            }

            if ($contractInfo->Freight == null || $contractInfo->Freight == 0) {
                $mainInfo['freight_price'] = $contractInfo->total_Freight / $rate;
            } else {
                $mainInfo['freight_price'] = $contractInfo->Freight * (!isset($mainInfo['total_sail_time']) ? 1 : $mainInfo['total_sail_time']);
            }

            // 货量(租期)
            $cgo_qty = VoySettleMain::where('shipId', $shipId)->where('voyId', $voyId)->first();
            if ($cgo_qty != null) {
                $mainInfo['cgo_qty'] = $cgo_qty->cgo_qty;
            } else {
                $mainInfo['cgo_qty'] = !isset($_cmpltCgoQty) ? '' : $_cmpltCgoQty;
            }

            $mainInfo['freight_price'] = round($mainInfo['freight_price'] / $rate, 2);
            $mainInfo['freight'] = $contractInfo->Freight;
            $mainInfo['freight'] = round($mainInfo['freight'] / $rate, 2);
            $mainInfo['lport'] = $portTbl->getPortNames($contractInfo->LPort);
            $mainInfo['dport'] = $portTbl->getPortNames($contractInfo->DPort);
            $mainInfo['com_fee'] = $contractInfo->com_fee;

            $fo_sailTmp1 = $contractInfo['up_ship_day'] + $contractInfo['down_ship_day'];
            $do_sailTmp1 = $fo_sailTmp1;
            $fo_sailTmp1 = $fo_sailTmp1 * $contractInfo['fo_up_shipping'];
            $fo_sailTmp2 = $contractInfo['fo_sailing'] * $contractInfo['sail_term'];
            $fo_sailTmp3 = $contractInfo['fo_waiting'] * $contractInfo['wait_day'];
            $mainInfo['fo_mt'] = round($fo_sailTmp1 + $fo_sailTmp2 + $fo_sailTmp3, 2);

            $do_sailTmp1 = $do_sailTmp1 * $contractInfo['do_up_shipping'];
            $do_sailTmp2 = $contractInfo['do_sailing'] * $contractInfo['sail_term'];
            $do_sailTmp3 = $contractInfo['do_waiting'] * $contractInfo['wait_day'];
            $mainInfo['do_mt'] = round($do_sailTmp1 + $do_sailTmp2 + $do_sailTmp3, 2);

            $fuelInfo['rob_fo_price_1'] = round($contractInfo->fo_price, 2);
            $fuelInfo['rob_do_price_1'] = round($contractInfo->do_price, 2);

            $fuelInfo['rob_fo_price_2'] = 0;
            $fuelInfo['rob_do_price_2'] = 0;

            $year = '20' . substr($contractInfo->Voy_No, 0, 2);
            $costs = ExpectedCosts::where('shipNo', $shipId)->where('year', $year)->first();
            if ($costs == null) {
                $elseCost = 0;
            } else {
                for ($i = 1; $i <= 11; ++$i ) {
                    if (!isset($costs['input' . $i]) || $costs['input' . $i] == '') {
                        $costs['input' . $i] = 0;
                    }
                }

                $elseCost = round(($costs['input4'] + $costs['input5'] + $costs['input6']) * 12 / 365, 0);
            }

            $mainInfo['cost_day'] = $contractInfo['cost_per_day'];
            $mainInfo['cost_else'] = round($elseCost * ($mainInfo['total_sail_time'] ?? 0));

            $mainInfo['manage_cost_day'] = round($mainInfo['cost_day'] * ($mainInfo['total_sail_time'] ?? 0), 2);
        } else {
            $mainInfo['cargo_name'] = '';
            $mainInfo['voy_type'] = '';
            $year = date('Y');
        }

        $rep = new DecisionReport();
        $debit_credit = $rep->getIncome($shipId, $voyId);
        $mainInfo['credit'] = $debit_credit[0];
        $mainInfo['sail_credit'] = isset($debit_credit[2][OUTCOME_FEE1]) ? round($debit_credit[2][OUTCOME_FEE1], 0) : 0;
        $mainInfo['soa_credit'] = $debit_credit[0] - $debit_credit[1];

        $mainInfo['freight_price'] ??= 0;

        $mainInfo['com_fee'] ??= 0;

        return $mainInfo;
    }

    public function getTermDay($start_date, $end_date, $start_gmt = 0, $end_gmt = 0)
    {
        $currentDate = strtotime($end_date) * 1000;
        $currentGMT = $this->_DAY_UNIT * $end_gmt;
        $prevDate = strtotime($start_date) * 1000;
        $prevGMT = $this->_DAY_UNIT * $start_gmt;
        $diffDay = 0;
        $currentDate = Decimal::create($currentDate - $currentGMT)->div(Decimal::create($this->_DAY_UNIT));
        $prevDate = Decimal::create($prevDate - $prevGMT)->div(Decimal::create($this->_DAY_UNIT));
        $diffDay = $currentDate->sub($prevDate)->div(Decimal::create(24))->__toString();

        return round($diffDay, 4);
    }

    public function deleteVoySettle($shipId, $voyId)
    {
        $ret = VoySettleMain::where('shipId', $shipId)->where('voyId', $voyId)->delete();
        $ret = VoySettleElse::where('shipId', $shipId)->where('voyId', $voyId)->delete();
        $ret = VoySettleFuel::where('shipId', $shipId)->where('voyId', $voyId)->delete();
        $ret = VoySettleProfit::where('shipId', $shipId)->where('voyId', $voyId)->delete();

        return $ret;
    }
}
