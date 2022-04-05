<?php
/**
 * Created by PhpStorm.
 * User: ChoeMunBong
 * Date: 2017/4/16
 * Time: 13:09.
 */

namespace App\Models\ShipMember;

use App\Models\ShipManage\Ship;
use App\Models\ShipManage\ShipRegister;
use App\Models\ShipTechnique\ShipPort;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShipMember extends Model
{
    protected $table = 'tb_ship_member';

    public function getShipNameAndPos()
    {
        $shipName = '';
        $dutyName = '';

        $ship = ShipRegister::where('RegNo', $this->ShipId)->first();
        if (!empty($ship)) {
            $shipName = $ship->shipName_Cn;

            $origin = Ship::find($ship->Shipid);
            if (!empty($origin)) {
                $shipName = $origin->name . ' ( ' . $ship->shipName_Cn . ' )';
            }
        }
        $duty = ShipPosReg::find($this->Duty);
        if (!empty($duty)) {
            $dutyName = $duty->Duty;
        }

        return $shipName . '号 ' . $dutyName;
    }

    public static function getMemberListOrderByShip($status = 1, $isParty = -1, $shipId = 0)
    {
        $query = static::query()->leftJoin('tb_ship', 'tb_ship_member.shipId', '=', 'tb_ship.id');
        if (isset($status)) {
            $query = $query->where('tb_ship_member.RegStatus', $status);
        }

        if ($isParty > -1) {
            $query = $query->where('tb_ship_member.isParty', $isParty);
        }

        if ($shipId > 0) {
            $query = $query->where('tb_ship_member.shipId', $shipId);
        }

        $query = $query->orderBy('tb_ship.id');
        $result = $query->get();

        return $result;
    }

    public static function getShipMemberListByKeyword($shipId, $shipPos, $name, $state)
    {
        $query = static::query()
            ->select(
                'tb_ship_member.id',
                'tb_ship_member.realname',
                'tb_ship_member.Surname',
                'tb_ship_member.GivenName',
                'tb_ship_member.birthday',
                'tb_ship_member.RegStatus',
                'tb_ship_member.tel',
                'tb_ship_member.phone',
                'tb_ship_duty.Duty',
                'tb_ship_duty.Duty_En',
                'tb_ship.name',
                'tb_capacity_registry.CapacityID',
                'tb_capacity_registry.GMDSSID',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                DB::raw('IFNULL(tb_ship.id, 100) as orderNum')
            )
            ->leftJoin('tb_ship_register', 'tb_ship_member.ShipId', '=', 'tb_ship_register.RegNo')
            ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
            ->leftJoin('tb_ship_duty', 'tb_ship_member.Duty', '=', 'tb_ship_duty.id')
            ->leftJoin('tb_capacity_registry', 'tb_ship_member.id', '=', 'tb_capacity_registry.memberId');
        if ($state > 0) {
            $status = $state - 1;
            $query = $query->where('tb_ship_member.RegStatus', $status);
        }
        if (isset($shipId) && !empty($shipId)) {
            $query->where('tb_ship_member.ShipId', $shipId);
        }

        if (isset($name) && !empty($name)) {
            $query->where('tb_ship_member.realname', 'like', '%' . $name . '%');
        }

        if (isset($shipPos) && !empty($shipPos)) {
            $query->where('tb_ship_member.Duty', $shipPos);
        }

        $query->orderBy('orderNum')->orderBy('tb_ship_duty.id')->orderBy('tb_ship_member.realname');
        $result = $query->get();

        return $result;
    }

    public static function getTotalMemberList($regShip = null, $bookShip = null, $origShip = null, $regStatus = null)
    {
        $query = static::query()
            ->select(
                'tb_ship_member.*',
                'tb_member_social_detail.isParty',
                'tb_member_social_detail.partyNo',
                'tb_member_social_detail.partyDate',
                'tb_member_social_detail.entryDate',
                'tb_member_social_detail.fromOrigin',
                'tb_member_social_detail.currOrigin',
                'tb_member_social_detail.cardNum',
                'tb_member_social_detail.isParty',
                'tb_ship_register.shipName_Cn',
                'tb_ship_duty.Duty',
                'tb_ship.name'
            )
            ->leftJoin('tb_member_social_detail', 'tb_ship_member.id', '=', 'tb_member_social_detail.memberId')
            ->leftJoin('tb_ship_register', 'tb_ship_member.ShipId', '=', 'tb_ship_register.RegNo')
            ->leftJoin('tb_ship_duty', 'tb_ship_member.Duty', '=', 'tb_ship_duty.id')
            ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id');
        if (!empty($regStatus)) {
            $query = $query->where('tb_ship_member.RegStatus', $regStatus - 1);
        }

        if (isset($regShip) && !empty($regShip)) {
            $query = $query->where('tb_ship_member.ShipId', $regShip);
        }

        if (isset($bookShip) && !empty($bookShip)) {
            $query = $query->where('tb_ship_member.ShipID_Book', $bookShip);
        }

        if (isset($origShip) && !empty($origShip)) {
            $query = $query->where('tb_ship_member.ShipID_organization', $origShip);
        }

        $result = $query->orderBy('tb_ship_register.RegNo')->orderBy('tb_ship_member.Duty')
            ->orderBy('tb_ship_member.realname')->get();

        return $result;
    }

    public static function getMemberCertList($ship, $pos, $capacity, $month, $page = 0, $perPage = 10)
    {
        $limit = '';
        if ($page != -1) {
            $start = ($page - 1) * $perPage;
            if ($start < 0) {
                $start = 0;
            }
            $limit = ' LIMIT ' . $start . ', ' . $perPage;
        }

        $query = 'SELECT tb_ship_member.id AS crewId, tb_ship_member.realname, tb_ship_register.shipName_Cn, tb_ship_member.crewNum,
				tb_ship_member.scanPath, tb_ship_member.Duty, tb_ship_member.DutyID_Book, tb_ship_duty.Duty AS ship_duty, tb_ship_member.ExpiryDate AS ship_ExpiryDate,
				book_member.shipName_Cn AS book_ship, book_member.book_id, book_member.Duty AS book_duty,
				general_capacity.CapacityID, general_capacity.capacity AS generalCapacity, general_capacity.GOC, general_capacity.ExpiryDate AS general_expireDate,
				GOC_capacity_table.GMDSSID, GOC_capacity_table.capacity AS GOC_capacity, GOC_capacity_table.GMDSS_Scan, GOC_capacity_table.GMD_ExpiryDate,
				COE_capacity_table.COEId, COE_capacity_table.capacity AS COE_capacity, COE_capacity_table.COE_Scan, COE_capacity_table.COE_ExpiryDate,COE_capacity_table.COE_Remarks,
				COE_GOC_capacity_table.COE_GOCId, COE_GOC_capacity_table.capacity AS COE_GOC_capacity, COE_GOC_capacity_table.COE_GOC_Scan, COE_GOC_capacity_table.COE_GOC_ExpiryDate,COE_GOC_capacity_table.COE_GOC_Remarks,
				Watch_capacity_table.WatchID, Watch_capacity_table.capacity AS Watch_capacity, Watch_capacity_table.Watch_Scan, Watch_capacity_table.Watch_ExpiryDate,
				tb_training_registry.TCBExpiryDate, tb_training_registry.TCBScan, tb_training_registry.TCSExpiryDate, tb_training_registry.TCSScan, tb_training_registry.TCPIssuedDate, tb_training_registry.TCPScan, tb_training_registry.TCP_certID,
				tb_training_registry.MCS_ExpiryDate, tb_training_registry.MCSScan, tb_training_registry.SSO_certID, tb_training_registry.SSOExpiryDate, tb_training_registry.SSOScan,
				tb_training_registry.ASD_typeID, tb_training_registry.ASDScan, tb_training_registry.ASDExpiryDate, ifNull(tb_ship_register.id, 100) as orderNum
			FROM tb_ship_member
			LEFT JOIN tb_ship_register ON tb_ship_member.ShipId = tb_ship_register.RegNo
			LEFT JOIN tb_ship_duty ON tb_ship_member.Duty = tb_ship_duty.id
			LEFT JOIN
				(SELECT tb_ship_member.id, tb_ship_register.shipName_Cn, tb_ship_duty.id AS book_id, tb_ship_duty.Duty FROM tb_ship_member
				LEFT JOIN tb_ship_register ON tb_ship_member.ShipID_Book = tb_ship_register.RegNo
				LEFT JOIN tb_ship_duty ON tb_ship_member.DutyID_Book = tb_ship_duty.id) book_member
				ON tb_ship_member.id = book_member.id
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.CapacityID, tb_capacity_registry.ExpiryDate, tb_capacity_registry.GOC, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.CapacityID = tb_member_capacity.id) general_capacity
				 ON tb_ship_member.id = general_capacity.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.GMDSSID, tb_capacity_registry.GMD_ExpiryDate, tb_capacity_registry.GMDSS_Scan, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.GMDSSID = tb_member_capacity.id) GOC_capacity_table
				 ON tb_ship_member.id = GOC_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.COEId, tb_capacity_registry.COE_ExpiryDate, tb_capacity_registry.COE_Scan, tb_member_capacity.capacity, tb_capacity_registry.COE_Remarks FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.COEId = tb_member_capacity.id) COE_capacity_table
				 ON tb_ship_member.id = COE_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.COE_GOCId, tb_capacity_registry.COE_GOC_ExpiryDate, tb_capacity_registry.COE_GOC_Scan, tb_member_capacity.capacity, tb_capacity_registry.COE_GOC_Remarks FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.COE_GOCId = tb_member_capacity.id) COE_GOC_capacity_table
				 ON tb_ship_member.id = COE_GOC_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.WatchID, tb_capacity_registry.Watch_Scan, tb_capacity_registry.Watch_ExpiryDate, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.WatchID = tb_member_capacity.id) Watch_capacity_table
				 ON tb_ship_member.id = Watch_capacity_table.memberId
			LEFT JOIN tb_training_registry ON tb_ship_member.id = tb_training_registry.memberId	WHERE tb_ship_member.RegStatus = 1 ';

        if (!empty($ship)) {
            $query .= ' AND tb_ship_member.ShipId = "' . $ship . '"';
        }
        if (!empty($pos)) {
            $query .= ' AND tb_ship_member.Duty = ' . $pos;
        }
        if (!empty($capacity)) {
            $query .= ' AND ((general_capacity.CapacityID = ' . $capacity . ') OR (GOC_capacity_table.GMDSSID = ' . $capacity . ') OR
					(COE_capacity_table.COEId = ' . $capacity . ') OR (COE_GOC_capacity_table.COE_GOCId = ' . $capacity . ') OR
					(Watch_capacity_table.WatchID = ' . $capacity . '))';
        }

        if (!empty($month)) {
            $date = new DateTime();
            $day = $month * 30;
            $date->modify("+$day day");
            $expireDate = $date->format('Y-m-d');

            $query .= 'AND (((general_capacity.ExpiryDate <> "") AND (general_capacity.ExpiryDate IS NOT NULL) AND (general_capacity.ExpiryDate < "' . $expireDate . '")) OR
			((tb_ship_member.ExpiryDate <> "") AND (tb_ship_member.ExpiryDate IS NOT NULL) AND (tb_ship_member.ExpiryDate < "' . $expireDate . '")) OR
			((GOC_capacity_table.GMD_ExpiryDate <> "") AND (GOC_capacity_table.GMD_ExpiryDate IS NOT NULL) AND (GOC_capacity_table.GMD_ExpiryDate < "' . $expireDate . '")) OR
			((COE_capacity_table.COE_ExpiryDate <> "") AND (COE_capacity_table.COE_ExpiryDate IS NOT NULL) AND (COE_capacity_table.COE_ExpiryDate < "' . $expireDate . '")) OR
			((COE_GOC_capacity_table.COE_GOC_ExpiryDate <> "") AND (COE_GOC_capacity_table.COE_GOC_ExpiryDate IS NOT NULL) AND (COE_GOC_capacity_table.COE_GOC_ExpiryDate < "' . $expireDate . '")) OR
			((Watch_capacity_table.Watch_ExpiryDate <> "") AND (Watch_capacity_table.Watch_ExpiryDate IS NOT NULL) AND (Watch_capacity_table.Watch_ExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.TCBExpiryDate <> "") AND (tb_training_registry.TCBExpiryDate IS NOT NULL) AND (tb_training_registry.TCBExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.TCSExpiryDate <> "") AND (tb_training_registry.TCSExpiryDate IS NOT NULL) AND (tb_training_registry.TCSExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.MCS_ExpiryDate <> "") AND (tb_training_registry.MCS_ExpiryDate IS NOT NULL) AND (tb_training_registry.MCS_ExpiryDate < "' . $expireDate . '")))';
        }

        $query .= ' ORDER BY orderNum, tb_ship_duty.id, tb_ship_member.realname ' . $limit;

        $result = DB::select($query);

        return $result;
    }

    public static function countMemberCertList($ship, $pos, $capacity, $month, $perPage = 10)
    {
        $query = 'SELECT COUNT(*) as totalCount FROM tb_ship_member
			LEFT JOIN tb_ship_register ON tb_ship_member.ShipId = tb_ship_register.RegNo
			LEFT JOIN tb_ship_duty ON tb_ship_member.Duty = tb_ship_duty.id
			LEFT JOIN
				(SELECT tb_ship_member.id, tb_ship_register.shipName_Cn, tb_ship_duty.Duty FROM tb_ship_member
				LEFT JOIN tb_ship_register ON tb_ship_member.ShipID_Book = tb_ship_register.RegNo
				LEFT JOIN tb_ship_duty ON tb_ship_member.DutyID_Book = tb_ship_duty.id) book_member
				ON tb_ship_member.id = book_member.id
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.CapacityID, tb_capacity_registry.ExpiryDate, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.CapacityID = tb_member_capacity.id) general_capacity
				 ON tb_ship_member.id = general_capacity.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.GMDSSID, tb_capacity_registry.GMD_ExpiryDate, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.GMDSSID = tb_member_capacity.id) GOC_capacity_table
				 ON tb_ship_member.id = GOC_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.COEId, tb_capacity_registry.COE_ExpiryDate, tb_member_capacity.capacity, tb_capacity_registry.COE_Remarks FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.COEId = tb_member_capacity.id) COE_capacity_table
				 ON tb_ship_member.id = COE_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.COE_GOCId, tb_capacity_registry.COE_GOC_ExpiryDate, tb_member_capacity.capacity, tb_capacity_registry.COE_GOC_Remarks FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.COE_GOCId = tb_member_capacity.id) COE_GOC_capacity_table
				 ON tb_ship_member.id = COE_GOC_capacity_table.memberId
			LEFT JOIN
				(SELECT tb_capacity_registry.memberId, tb_capacity_registry.WatchID, tb_capacity_registry.Watch_ExpiryDate, tb_member_capacity.capacity FROM tb_capacity_registry
				 INNER JOIN tb_member_capacity ON tb_capacity_registry.WatchID = tb_member_capacity.id) Watch_capacity_table
				 ON tb_ship_member.id = Watch_capacity_table.memberId
			LEFT JOIN tb_training_registry ON tb_ship_member.id = tb_training_registry.memberId	WHERE tb_ship_member.RegStatus = 1 ';

        if (!empty($ship)) {
            $query .= ' AND tb_ship_member.ShipId = "' . $ship . '"';
        }
        if (!empty($pos)) {
            $query .= ' AND tb_ship_member.Duty = ' . $pos;
        }
        if (!empty($capacity)) {
            $query .= ' AND ((general_capacity.CapacityID = ' . $capacity . ') OR (GOC_capacity_table.GMDSSID = ' . $capacity . ') OR
					(COE_capacity_table.COEId = ' . $capacity . ') OR (COE_GOC_capacity_table.COE_GOCId = ' . $capacity . ') OR
					(Watch_capacity_table.WatchID = ' . $capacity . '))';
        }

        if (!empty($month)) {
            $date = new DateTime();
            $day = $month * 30;
            $date->modify("+$day day");
            $expireDate = $date->format('Y-m-d');

            $query .= 'AND (((general_capacity.ExpiryDate <> "") AND (general_capacity.ExpiryDate IS NOT NULL) AND (general_capacity.ExpiryDate < "' . $expireDate . '")) OR
			((GOC_capacity_table.GMD_ExpiryDate <> "") AND (GOC_capacity_table.GMD_ExpiryDate IS NOT NULL) AND (GOC_capacity_table.GMD_ExpiryDate < "' . $expireDate . '")) OR
			((COE_capacity_table.COE_ExpiryDate <> "") AND (COE_capacity_table.COE_ExpiryDate IS NOT NULL) AND (COE_capacity_table.COE_ExpiryDate < "' . $expireDate . '")) OR
			((COE_GOC_capacity_table.COE_GOC_ExpiryDate <> "") AND (COE_GOC_capacity_table.COE_GOC_ExpiryDate IS NOT NULL) AND (COE_GOC_capacity_table.COE_GOC_ExpiryDate < "' . $expireDate . '")) OR
			((Watch_capacity_table.Watch_ExpiryDate <> "") AND (Watch_capacity_table.Watch_ExpiryDate IS NOT NULL) AND (Watch_capacity_table.Watch_ExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.TCBExpiryDate <> "") AND (tb_training_registry.TCBExpiryDate IS NOT NULL) AND (tb_training_registry.TCBExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.TCSExpiryDate <> "") AND (tb_training_registry.TCSExpiryDate IS NOT NULL) AND (tb_training_registry.TCSExpiryDate < "' . $expireDate . '")) OR
			((tb_training_registry.MCS_ExpiryDate <> "") AND (tb_training_registry.MCS_ExpiryDate IS NOT NULL) AND (tb_training_registry.MCS_ExpiryDate < "' . $expireDate . '")))';
        }

        $result = DB::select($query);

        $page = 0;
        if (count($result) > 0) {
            $totalCount = $result[0]->totalCount;
            $page = floor($totalCount / $perPage);
            $remain = fmod($totalCount, $perPage);
            if ($remain > 0) {
                ++$page;
            }

            return $page;
        }

        return $page;
    }

    public static function getMemberSimpleInfo($shipReg = null, $pagenation = 1000)
    {
        $query = static::query()->select('tb_ship_member.id', 'tb_ship_member.realname', 'tb_ship_register.shipName_Cn', 'tb_ship_duty.Duty', 'tb_member_capacity.Capacity')
            ->leftJoin('tb_ship_register', 'tb_ship_member.ShipId', '=', 'tb_ship_register.RegNo')
            ->leftJoin('tb_ship_duty', 'tb_ship_member.Duty', '=', 'tb_ship_duty.id')
            ->leftJoin('tb_member_capacity', 'tb_ship_member.QualificationClass', '=', 'tb_member_capacity.id')
            ->where('tb_ship_member.RegStatus', '1');
        if (isset($shipReg)) {
            $query = $query->where('tb_ship_member.ShipId', $shipReg);
        }

        $query = $query->orderBy('tb_ship_register.id', 'desc')->orderBy('tb_ship_duty.id');
        $result = $query->paginate($pagenation);

        return $result;
    }

    public static function getMemberListByCommar($shipId = null)
    {
        if (!empty($shipId)) {
            $query = 'SELECT GROUP_CONCAT(id) AS shipMember FROM tb_ship_member WHERE tb_ship_member.RegStatus = 1 AND ShipId = "' . $shipId . '"';
        } else {
            $query = 'SELECT GROUP_CONCAT(id) AS shipMember FROM tb_ship_member WHERE tb_ship_member.RegStatus = 1 AND (ShipId IS NULL OR ShipId = "" OR ShipId="(READY)")';
        }
        $result = DB::select($query);
        if (count($result)) {
            $result = $result[0]->shipMember;
        } else {
            $result = '';
        }

        return $result;
    }

    public function getCertlistByShipId($IMO_No)
    {
        $selector = null;
        $records = [];
        $selector = DB::table($this->table)->select('*')->where('ShipId', $IMO_No)->orderBy('id', 'asc');
        $records = $selector->get();
        $memberlist = [];
        foreach ($records as $index => $record) {
            $rank = ShipPosition::find($record->DutyID_Book);
            $rank_name = (!empty($rank) && $rank != null) ? $rank->Duty_En : '';
            if ($rank_name == 'MASTER' || $rank_name == '2nd DECK OFFICER' || $rank_name == '3rd DECK OFFICER' || $rank_name == 'CHIEF MATE' ||
                $rank_name == '2nd ENGINEER OFFICER' || $rank_name == '3rd ENGINEER OFFICER' || $rank_name == 'RADIO OFFICER' || $rank_name == 'CHIEF ENGINEER') {
                if (!isset($memberlist[$rank_name])) {
                    $memberlist[$rank_name] = ShipCapacityRegister::select('ItemNo', 'COC_IssuedDate', 'COC_ExpiryDate', 'GMDSS_NO', 'GMD_IssuedDate', 'GMD_ExpiryDate')
                        ->where('memberId', $record->id)->first();
                }
            }
        }

        return $memberlist;
    }

    public function getForCertDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;

        $selector = DB::table($this->table)->select('*');
        if (isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $selector->where('ShipId', $params['columns'][2]['search']['value']);
        }

        $selector->whereNotNull('DateOnboard')
            ->where(function ($query): void {
                $today = date('Y-m-d');
                $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
            });

        //$expire_days = null;
        //if (isset($params['columns'][3]['search']['value']) && $params['columns'][3]['search']['value'] !== '')
        $expire_days = $params['columns'][3]['search']['value'];

        $selector->orderBy('DutyID_Book', 'asc');
        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        $capacityList = ShipMemberCapacity::all();
        $today = time();
        $count = 0;
        $totalIndex = 0;
        foreach ($records as $index => $record) {
            $count = 0;
            $rank = ShipPosition::find($record->DutyID_Book);
            $capacity = ShipCapacityRegister::where('memberId', $record->id)->first();
            $training = ShipMemberTraining::where('memberId', $record->id)->groupBy('CertSequence')->get();
            $othercert = ShipMemberOtherCert::where('memberId', $record->id)->get();
            for ($i = 0; $i < 20; ++$i) {
                $newArr[$newindex]['no'] = $totalIndex + 1;
                $newArr[$newindex]['name'] = $record->realname;
                $newArr[$newindex]['rank'] = '&nbsp;';
                if (!empty($rank) && $rank != null) {
                    $newArr[$newindex]['rank'] = $rank->Abb;
                }
                $newArr[$newindex]['_no'] = '';
                $newArr[$newindex]['_issue'] = '';
                $newArr[$newindex]['_expire'] = '';
                $newArr[$newindex]['_by'] = '';
                $newArr[$newindex]['_type'] = '';
                if ($i == 0) {
                    $newArr[$newindex]['_no'] = $record->crewNum;
                    $newArr[$newindex]['_issue'] = $record->IssuedDate;
                    $newArr[$newindex]['_expire'] = $record->ExpiryDate;
                    $newArr[$newindex]['_by'] = '';
                } elseif ($i == 1) {
                    $newArr[$newindex]['_no'] = $record->PassportNo;
                    $newArr[$newindex]['_issue'] = $record->PassportIssuedDate;
                    $newArr[$newindex]['_expire'] = $record->PassportExpiryDate;
                    $newArr[$newindex]['_by'] = '';
                } elseif ($i == 2) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['ItemNo'];
                        $newArr[$newindex]['_issue'] = $capacity['COC_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COC_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COC_Remarks'];
                        foreach ($capacityList as $type) {
                            if ($type->id == $capacity['CapacityID']) {
                                $newArr[$newindex]['_type'] = $type->Capacity_En;

                                break;
                            }
                        }
                    }
                } elseif ($i == 3) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['COENo'];
                        $newArr[$newindex]['_issue'] = $capacity['COE_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COE_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COE_Remarks'];

                        foreach ($capacityList as $type) {
                            if ($type->id == $capacity['COEId']) {
                                $newArr[$newindex]['_type'] = $type->Capacity_En;

                                break;
                            }
                        }
                    }
                } elseif ($i == 4) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['GMDSS_NO'];
                        $newArr[$newindex]['_issue'] = $capacity['GMD_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['GMD_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['GMD_Remarks'];
                    }
                } elseif ($i == 5) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['COE_GOCNo'];
                        $newArr[$newindex]['_issue'] = $capacity['COE_GOC_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COE_GOC_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COE_GOC_Remarks'];
                    }
                } elseif ($i < 15) {
                    if (isset($training[$i - 6])) {
                        $newArr[$newindex]['_no'] = $training[$i - 6]->CertNo;
                        $newArr[$newindex]['_issue'] = $training[$i - 6]->IssueDate;
                        $newArr[$newindex]['_expire'] = $training[$i - 6]->ExpireDate;
                        $newArr[$newindex]['_by'] = $training[$i - 6]->IssuedBy;
                    }
                } else {
                    if (isset($othercert[$i - 15])) {
                        $newArr[$newindex]['_no'] = $othercert[$i - 15]->CertNo;
                        $newArr[$newindex]['_name'] = $othercert[$i - 15]->CertName;
                        $newArr[$newindex]['_issue'] = $othercert[$i - 15]->IssueDate;
                        $newArr[$newindex]['_expire'] = $othercert[$i - 15]->ExpireDate;
                        $newArr[$newindex]['_by'] = $othercert[$i - 15]->IssuedBy;
                    }
                }

                $newArr[$newindex]['index'] = $i;
                if ($newArr[$newindex]['_issue'] == '' || $newArr[$newindex]['_issue'] == null) {
                    unset($newArr[$newindex]);

                    continue;
                }

                if ($expire_days != 0) {
                    $datediff = strtotime2($newArr[$newindex]['_expire']) - $today;
                    if (round($datediff / (60 * 60 * 24)) > $expire_days) {
                        unset($newArr[$newindex]);

                        continue;
                    }
                }
                ++$count;
                $newArr[$newindex]['count'] = $count;
                ++$newindex;
            }
            if ($count > 0) {
                ++$totalIndex;
            }
        }
        if ($count == 0) {
            unset($newArr[$newindex]);
        }
        if ($newindex == 0) {
            $newArr = [];
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getSendList($params, $wage_list_record, $shipId, $year, $month)
    {
        $selector = ShipWageSend::where('shipId', $shipId)->where('year', $year)->where('month', $month);
        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        foreach ($records as $index => $record) {
            $newArr[$newindex]['no'] = $record->member_id;
            $newArr[$newindex]['name'] = $record->name;
            $newArr[$newindex]['rank'] = $record->rank;
            $newArr[$newindex]['cashR'] = $record->cashR;
            $newArr[$newindex]['sendR'] = $record->sendR;
            $newArr[$newindex]['sendD'] = $record->sendD;
            $newArr[$newindex]['purchdate'] = $record->purchdate;
            /*
            if ($record->purchdate == null || $record->purchdate == '')
                $newArr[$newindex]['purchdate'] = '';
            else
                $newArr[$newindex]['purchdate'] = date('Y-m-d', strtotime($record->purchdate));
            */
            $newArr[$newindex]['sendbank'] = $record->sendbank;
            $newArr[$newindex]['bankinfo'] = $record->bankinfo;
            $newArr[$newindex]['remark'] = $record->remark;
            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => $recordsFiltered,
            'recordsFiltered' => $recordsFiltered,
            'original' => false,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getWageById($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;

        if (isset($params['columns'][1]['search']['value'])
            && $params['columns'][1]['search']['value'] !== ''
            && isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $member_id = $params['columns'][1]['search']['value'];
            $year = $params['columns'][2]['search']['value'];
        } else {
            $member_id = $params['member_id'];
            $year = $params['year'];
        }

        $selector = ShipWageSend::where('member_id', $member_id)->where('year', $year);

        $records = $selector->get()->keyBy('month');
        $newArr = [];
        $sumR = 0;
        $sumD = 0;
        for ($i = 0; $i < 12; ++$i) {
            $newArr[$i]['no'] = $i + 1;
            if (!isset($records[$i + 1])) {
                $newArr[$i]['sendR'] = 0;
                $newArr[$i]['sendD'] = 0;
                $newArr[$i]['purchdate'] = '';
                $newArr[$i]['bankinfo'] = '';
            } else {
                $newArr[$i]['sendR'] = $records[$i + 1]->sendR == '' ? 0 : $records[$i + 1]->sendR;
                $newArr[$i]['sendD'] = $records[$i + 1]->sendD == '' ? 0 : $records[$i + 1]->sendD;
                $newArr[$i]['purchdate'] = $records[$i + 1]->purchdate;
                $newArr[$i]['bankinfo'] = $records[$i + 1]->bankinfo;
            }
            $sumR += $newArr[$i]['sendR'];
            $sumD += $newArr[$i]['sendD'];
        }
        $newArr[12]['no'] = '合计';
        $newArr[12]['totalR'] = '';
        $newArr[12]['totalD'] = '';
        $newArr[12]['sendR'] = $sumR;
        $newArr[12]['sendD'] = $sumD;
        $newArr[12]['purchdate'] = '';
        $newArr[12]['bankinfo'] = '';

        $member_info = self::where('id', $member_id)->first();
        $member_shipid = $member_info['ShipId'];

        $recordsFiltered = $selector->count();

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => 12,
            'recordsFiltered' => 12,
            'original' => false,
            'member_shipid' => $member_shipid,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForSendWageDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        if (!isset($params['columns'][3]['search']['value']) ||
            $params['columns'][3]['search']['value'] == '' ||
            !isset($params['columns'][4]['search']['value']) ||
            $params['columns'][4]['search']['value'] == ''
        ) {
            $year = $params['year'];
            $month = $params['month'];
            $shipId = $params['shipId'];
        } else {
            $shipId = $params['columns'][2]['search']['value'];
            $year = $params['columns'][3]['search']['value'];
            $month = $params['columns'][4]['search']['value'];
        }

        $wage_list_record = ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 1)->first();
        if (null !== $wage_list_record) {
            return $this->getSendList($params, $wage_list_record, $shipId, $year, $month);
        }

        $selector = ShipWage::where('shipId', $shipId)->where('year', $year)->where('month', $month);
        $records = $selector->get();
        $recordsFiltered = $selector->count();
        $newArr = [];
        $newindex = 0;
        foreach ($records as $index => $record) {
            $newArr[$newindex]['no'] = $record->member_id;
            $newArr[$newindex]['name'] = $record->name;
            $newArr[$newindex]['rank'] = $record->rank;
            $newArr[$newindex]['cashR'] = $record->cashR;
            $newArr[$newindex]['sendR'] = $record->cashR;
            $newArr[$newindex]['sendD'] = '';
            if ($record->purchdate == null || $record->purchdate == '') {
                $newArr[$newindex]['purchdate'] = '';
            } else {
                $newArr[$newindex]['purchdate'] = date('Y-m-d', strtotime($record->purchdate));
            }
            $newArr[$newindex]['sendbank'] = 100;
            $newArr[$newindex]['bankinfo'] = $record->bankinfo;
            $newArr[$newindex]['remark'] = $record->remark;
            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => $recordsFiltered,
            'recordsFiltered' => $recordsFiltered,
            'original' => true,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getCalcList($params, $wage_list_record, $shipId, $year, $month)
    {
        $selector = ShipWage::where('shipId', $shipId)->where('year', $year)->where('month', $month);
        $records = $selector->get();
        $recordsFiltered = $selector->count();
        $newArr = [];
        $newindex = 0;
        //return $records;
        foreach ($records as $index => $record) {
            $newArr[$newindex]['no'] = $record->member_id;
            $newArr[$newindex]['name'] = $record->name;
            $newArr[$newindex]['rank'] = $record->rank;
            $newArr[$newindex]['WageCurrency'] = $record->currency;
            $newArr[$newindex]['Salary'] = $record->salary;
            if ($record->signondate == null) {
                $newArr[$newindex]['DateOnboard'] = '';
            } else {
                $newArr[$newindex]['DateOnboard'] = date('Y-m-d', strtotime($record->signondate));
            }

            if ($record->signoffdate == null) {
                $newArr[$newindex]['DateOffboard'] = '';
            } else {
                $newArr[$newindex]['DateOffboard'] = date('Y-m-d', strtotime($record->signoffdate));
            }

            $newArr[$newindex]['SignDays'] = $record->signdays;
            $newArr[$newindex]['MinusCash'] = $record->minuscash;
            $newArr[$newindex]['TransInR'] = $record->cashR;
            $newArr[$newindex]['TransInD'] = $record->cashD;
            if ($record->purchdate == null) {
                $newArr[$newindex]['TransDate'] = '';
            } else {
                $newArr[$newindex]['TransDate'] = date('Y-m-d', strtotime($record->purchdate));
            }
            $newArr[$newindex]['Remark'] = $record->remark;
            $newArr[$newindex]['BankInformation'] = $record->bankinfo;
            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => $recordsFiltered,
            'recordsFiltered' => $recordsFiltered,
            'info' => $wage_list_record,
            'original' => false,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForWageDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        if (!isset($params['columns'][2]['search']['value']) ||
            $params['columns'][2]['search']['value'] == '' ||
            !isset($params['columns'][3]['search']['value']) ||
            $params['columns'][3]['search']['value'] == '' ||
            !isset($params['columns'][4]['search']['value']) ||
            $params['columns'][4]['search']['value'] == '' ||
            !isset($params['columns'][5]['search']['value']) ||
            $params['columns'][5]['search']['value'] == '' ||
            !isset($params['columns'][6]['search']['value']) ||
            $params['columns'][6]['search']['value'] == ''
        ) {
            $year = $params['year'];
            $month = $params['month'];
            $minus_days = $params['minus_days'];
            $rate = $params['rate'];
            $shipId = $params['shipId'];
        } else {
            $shipId = $params['columns'][2]['search']['value'];
            $year = $params['columns'][3]['search']['value'];
            $month = $params['columns'][4]['search']['value'];
            $minus_days = $params['columns'][5]['search']['value'];
            $rate = $params['columns'][6]['search']['value'];
        }
        $wage_list_record = ShipWageList::where('shipId', $shipId)->where('year', $year)->where('month', $month)->where('type', 0)->first();
        if (null !== $wage_list_record) {
            return $this->getCalcList($params, $wage_list_record, $shipId, $year, $month);
        }

        $selector = DB::table($this->table)->where('ShipId', $shipId);

        $next_year = $year;
        $next_month = $month;
        if ($month == 12) {
            $next_month = 1;
            ++$next_year;
        } else {
            $next_month = $month + 1;
        }
        $now = date('Y-m-d', strtotime("$year-$month-1"));
        $next = date('Y-m-d', strtotime("$next_year-$next_month-1"));
        $next = date('Y-m-d', strtotime('-1 day', strtotime($next)));

        $selector->where(function ($query) use ($now, $next): void {
            $query->orWhere(function ($query) use ($now, $next): void {
                $query->where('DateOnboard', '<=', $next)->where('DateOffboard', '>=', $now);
            })->orWhere(function ($query) use ($next): void {
                $query->whereNotNull('DateOnboard')->where('DateOnboard', '<=', $next)->whereNull('DateOffboard');
            });
        });
        $today = date('Y-m-d');
        $selector->orderBy('DutyID_Book');
        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        foreach ($records as $index => $record) {
            $newArr[$newindex]['no'] = $record->id;
            $rank = ShipPosition::find($record->DutyID_Book);
            $newArr[$newindex]['rank'] = '&nbsp;';
            if (!empty($rank) && $rank != null) {
                $newArr[$newindex]['rank'] = $rank->Abb;
            }

            if ($record->Nationality == 'CHINA') {
                $newArr[$newindex]['name'] = $record->GivenName;
            } else {
                $newArr[$newindex]['name'] = $record->realname;
            }

            $newArr[$newindex]['WageCurrency'] = $record->WageCurrency;
            $newArr[$newindex]['Salary'] = $record->Salary;

            if ($record->DateOnboard <= $now) {
                $newArr[$newindex]['DateOnboard'] = $now;
            } else {
                $newArr[$newindex]['DateOnboard'] = $record->DateOnboard;
            }

            if ($record->DateOffboard == null || $record->DateOffboard >= $next) {
                $newArr[$newindex]['DateOffboard'] = $next;
            } else {
                $newArr[$newindex]['DateOffboard'] = $record->DateOffboard;
            }
            $month_total_days = round((strtotime($next) - strtotime($now)) / (60 * 60 * 24)) + 1;
            if ($newArr[$newindex]['DateOnboard'] == $now && $newArr[$newindex]['DateOffboard'] == $next) {
                $newArr[$newindex]['SignDays'] = $month_total_days;
            } else {
                $newArr[$newindex]['SignDays'] = round((strtotime($newArr[$newindex]['DateOffboard']) - strtotime($newArr[$newindex]['DateOnboard'])) / (60 * 60 * 24)) - $minus_days + 1;
            }

            $newArr[$newindex]['MinusCash'] = 0;
            if ($record->WageCurrency == 0) {
                if ($record->Salary == '') {
                    $newArr[$newindex]['TransInR'] = 0 - $newArr[$newindex]['MinusCash'];
                } else {
                    $newArr[$newindex]['TransInR'] = $record->Salary * $newArr[$newindex]['SignDays'] / $month_total_days - $newArr[$newindex]['MinusCash'];
                    //return $record->Salary * $newArr[$newindex]['SignDays'] / $month_total_days;
                }
                $newArr[$newindex]['TransInD'] = $newArr[$newindex]['TransInR'] / $rate;
            } else {
                if ($record->Salary == '') {
                    $newArr[$newindex]['TransInD'] = 0 - $newArr[$newindex]['MinusCash'];
                } else {
                    $newArr[$newindex]['TransInD'] = $record->Salary * $newArr[$newindex]['SignDays'] / $month_total_days - $newArr[$newindex]['MinusCash'];
                }
                $newArr[$newindex]['TransInR'] = $newArr[$newindex]['TransInD'] * $rate;
            }

            $newArr[$newindex]['TransDate'] = '';
            $newArr[$newindex]['Remark'] = '';
            $newArr[$newindex]['BankInformation'] = $record->BankInformation;
            $newArr[$newindex]['DateOnboard'] = $record->DateOnboard;

            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'original' => true,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForShipWageListDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        if (!isset($params['columns'][3]['search']['value']) ||
            $params['columns'][3]['search']['value'] == ''
        ) {
            $year = $params['year'];
            $shipId = $params['shipId'];
        } else {
            $shipId = $params['columns'][2]['search']['value'];
            $year = $params['columns'][3]['search']['value'];
        }

        $selector = ShipWage::where('shipId', $shipId)->where('year', $year)
            ->selectRaw('month, SUM(cashR) as totalR, SUM(cashD) as totalD')
            ->groupBy('month');

        $records = $selector->get()->keyBy('month');
        $newArr = [];
        $sumR = 0;
        $sumD = 0;
        for ($i = 0; $i < 12; ++$i) {
            $newArr[$i]['no'] = $i + 1;
            if (!isset($records[$i + 1])) {
                $newArr[$i]['totalR'] = 0;
                $newArr[$i]['totalD'] = 0;
            } else {
                $newArr[$i]['totalR'] = $records[$i + 1]->totalR;
                $newArr[$i]['totalD'] = $records[$i + 1]->totalD;
            }
            $sumR += $newArr[$i]['totalR'];
            $sumD += $newArr[$i]['totalD'];
        }
        $newArr[12]['no'] = '合计';
        $newArr[12]['totalR'] = $sumR;
        $newArr[12]['totalD'] = $sumD;

        $recordsFiltered = $selector->count();

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => 12,
            'recordsFiltered' => 12,
            'original' => false,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForWholeDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        $selector = DB::table($this->table)->select('*');

        if (isset($params['columns'][1]['search']['value'])
            && $params['columns'][1]['search']['value'] !== ''
        ) {
            $selector->where('ShipId', $params['columns'][1]['search']['value']);
        } else {
            return [
                'draw' => $params['draw'] + 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 0,
            ];
        }

        $selector->orderBy('DutyID_Book');
        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        //for($i=0;$i<10;$i++)
        foreach ($records as $index => $record) {
            if ($record->PassportNo == $record->crewNum) {
                $record->crewNum = '';
            }

            if ($record->Nationality == 'CHINA') {
                $newArr[$newindex]['name'] = $record->GivenName;
            } else {
                $newArr[$newindex]['name'] = $record->realname;
            }

            $newArr[$newindex]['rank'] = '&nbsp;';
            $rank = ShipPosition::find($record->DutyID_Book);
            if (!empty($rank) && $rank != null) {
                $newArr[$newindex]['rank'] = $rank->Abb;
            }
            $newArr[$newindex]['nationality'] = $record->Nationality;
            $newArr[$newindex]['cert-id'] = $record->CertNo;
            $newArr[$newindex]['birthday'] = $record->birthday;
            $newArr[$newindex]['birthplace'] = $record->BirthPlace;
            $newArr[$newindex]['signon-date'] = $record->DateOnboard;

            $newArr[$newindex]['signon-port'] = $record->PortID_Book;
            /*
            $port = ShipPort::find($record->PortID_Book);
            $newArr[$newindex]['signon-port'] = '&nbsp;';
            if(!empty($port) && $port != null) $newArr[$newindex]['signon-port'] = $port->Port_En;
            */
            $newArr[$newindex]['signoff-date'] = $record->DateOffboard;
            $newArr[$newindex]['bookno'] = $record->crewNum;
            $newArr[$newindex]['bookno-expire'] = $record->ExpiryDate;
            $newArr[$newindex]['passport-no'] = $record->PassportNo;
            $newArr[$newindex]['passport-expire'] = $record->PassportExpiryDate;
            $newArr[$newindex]['phone'] = $record->phone;
            $newArr[$newindex]['address'] = $record->address;
            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForDatatable($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        $selector = DB::table($this->table)->select('*');
        if (isset($params['columns'][1]['search']['value'])
            && $params['columns'][1]['search']['value'] !== ''
        ) {
            //$selector->where('realname', 'like', '%' . $params['columns'][1]['search']['value'] . '%');
            $selector->where('realname', $params['columns'][1]['search']['value']);
        }

        if (isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $selector->where('ShipId', $params['columns'][2]['search']['value']);
        }

        if (isset($params['columns'][3]['search']['value'])
            && $params['columns'][3]['search']['value'] !== ''
        ) {
            if ($params['columns'][3]['search']['value'] == 'true') {
                // DateOnBoard != null && (DateOffboard == null or Dateoffboard > today) // && (DateOnBoard < today)
                $selector->whereNotNull('DateOnboard');
                $selector->where(function ($query): void {
                    $today = date('Y-m-d');
                    $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
                });
            } elseif ($params['columns'][3]['search']['value'] == 'false') {
                // DateOnboard == null or (Dateoffboard <= today)
                $selector->where(function ($query): void {
                    $today = date('Y-m-d');
                    $query->whereNull('DateOnboard')->orWhere('DateOffboard', '<=', $today);
                });
            } else {
                // $selector->whereNull('DateOffboard')->orWhere('DateOffboard', '');
                $selector->whereNotNull('DateOnboard');
                $selector->where(function ($query): void {
                    $today = date('Y-m-d');
                    $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
                });
            }
        }

        $selector->orderBy('DutyID_Book');
        if (!isset($params['type'])) {
            $selector->orderBy('id', 'desc')->limit(1);
        }

        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        //for($i=0;$i<10;$i++)
        foreach ($records as $index => $record) {
            if ($record->PassportNo == $record->crewNum) {
                $record->crewNum = '';
            }
            $newArr[$newindex]['no'] = $record->id;
            $newArr[$newindex]['name'] = $record->realname;
            $rank = ShipPosition::find($record->DutyID_Book);
            $newArr[$newindex]['rank'] = '&nbsp;';
            if (!empty($rank) && $rank != null) {
                $newArr[$newindex]['rank'] = $rank->Abb;
            }
            $newArr[$newindex]['nationality'] = $record->Nationality;
            $newArr[$newindex]['cert-id'] = $record->CertNo;
            $newArr[$newindex]['birth-and-place'] = $record->birthday;
            $newArr[$newindex]['date-and-embarkation'] = $record->DateOnboard;
            $newArr[$newindex]['bookno-expire'] = $record->crewNum;
            $newArr[$newindex]['passport-expire'] = $record->PassportNo;
            ++$newindex;
            $newArr[$newindex]['no'] = $record->id;
            $newArr[$newindex]['name'] = $record->GivenName;
            $newArr[$newindex]['rank'] = '&nbsp;';
            if (!empty($rank) && $rank != null) {
                $newArr[$newindex]['rank'] = $rank->Abb;
            }
            $newArr[$newindex]['nationality'] = $record->Nationality;
            $newArr[$newindex]['cert-id'] = $record->CertNo;
            $newArr[$newindex]['birth-and-place'] = $record->BirthPlace;

            $newArr[$newindex]['date-and-embarkation'] = $record->PortID_Book;
            /*$port = ShipPort::find($record->PortID_Book);
            $newArr[$newindex]['date-and-embarkation'] = '&nbsp;';
            if(!empty($port) && $port != null) $newArr[$newindex]['date-and-embarkation'] = $port->Port_En;
            */

            $newArr[$newindex]['bookno-expire'] = $record->ExpiryDate;
            $newArr[$newindex]['passport-expire'] = $record->PassportExpiryDate;
            ++$newindex;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getForDatatableAll($params)
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;
        $selector = DB::table($this->table)->select('*');
        if (isset($params['columns'][1]['search']['value'])
            && $params['columns'][1]['search']['value'] !== ''
        ) {
            $name = $params['columns'][1]['search']['value'];
        } else {
            $name = $params['name'];
        }

        $selector->where('realname', $name);
        $record = $selector->first();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        if (isset($record)) {
            $newArr[$newindex]['no'] = $record->id;
            if ($record->Nationality == 'CHINA') {
                $newArr[$newindex]['name'] = $record->GivenName;
            } else {
                $newArr[$newindex]['name'] = $record->realname;
            }

            $ship = ShipRegister::where('IMO_No', $record->ShipId)->first();
            $newArr[$newindex]['ship'] = '&nbsp;';
            if (!empty($ship) && $ship != null) {
                $newArr[$newindex]['ship'] = $ship->shipName_En;
            }

            $rank = ShipPosition::find($record->DutyID_Book);
            $newArr[$newindex]['rank'] = '&nbsp;';
            if (!empty($rank) && $rank != null) {
                $newArr[$newindex]['rank'] = $rank->Abb;
            }

            $newArr[$newindex]['currency'] = $record->WageCurrency;
            $newArr[$newindex]['salary'] = $record->Salary;
            $newArr[$newindex]['dateonboard'] = $record->DateOnboard;
            $newArr[$newindex]['dateoffboard'] = $record->DateOffboard;
        }

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $newArr,
            'error' => 0,
        ];
    }

    public function getExpiredList($date = 0, $ship_id = '')
    {
        $selector = null;
        $records = [];
        $recordsFiltered = 0;

        $selector = DB::table($this->table)->select('*');
        if ($ship_id != '') {
            $selector->where('ShipId', $ship_id);
        }

        $selector->whereNotNull('DateOnboard')
            ->where(function ($query): void {
                $today = date('Y-m-d');
                $query->whereNull('DateOffboard')->orWhere('DateOffboard', '>', $today);
            });

        $expire_days = $date;

        $selector->orderBy('DutyID_Book', 'asc');
        $records = $selector->get();
        $recordsFiltered = $selector->count();

        $newArr = [];
        $newindex = 0;
        $capacityList = ShipMemberCapacity::all();
        $today = time();
        $count = 0;
        $totalIndex = 0;
        $shipReg = new ShipRegister();
        foreach ($records as $index => $record) {
            $count = 0;
            $rank = ShipPosition::find($record->DutyID_Book);
            $capacity = ShipCapacityRegister::where('memberId', $record->id)->first();
            $training = ShipMemberTraining::where('memberId', $record->id)->groupBy('CertSequence')->get();
            $othercert = ShipMemberOtherCert::where('memberId', $record->id)->get();
            for ($i = 0; $i < 20; ++$i) {
                $newArr[$newindex]['no'] = $totalIndex + 1;
                $newArr[$newindex]['name'] = $record->realname;
                $newArr[$newindex]['rank'] = '&nbsp;';
                if (!empty($rank) && $rank != null) {
                    $newArr[$newindex]['rank'] = $rank->Abb;
                }
                $newArr[$newindex]['_no'] = '';
                $newArr[$newindex]['_issue'] = '';
                $newArr[$newindex]['_expire'] = '';
                $newArr[$newindex]['_by'] = '';
                $newArr[$newindex]['_type'] = '';
                $newArr[$newindex]['shipName'] = $shipReg->getShipNameByIMO($record->ShipId);

                if ($i == 0) {
                    $newArr[$newindex]['_no'] = $record->crewNum;
                    $newArr[$newindex]['_issue'] = $record->IssuedDate;
                    $newArr[$newindex]['_expire'] = $record->ExpiryDate;
                    $newArr[$newindex]['_by'] = '';
                } elseif ($i == 1) {
                    $newArr[$newindex]['_no'] = $record->PassportNo;
                    $newArr[$newindex]['_issue'] = $record->PassportIssuedDate;
                    $newArr[$newindex]['_expire'] = $record->PassportExpiryDate;
                    $newArr[$newindex]['_by'] = '';
                } elseif ($i == 2) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['ItemNo'];
                        $newArr[$newindex]['_issue'] = $capacity['COC_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COC_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COC_Remarks'];
                        foreach ($capacityList as $type) {
                            if ($type->id == $capacity['CapacityID']) {
                                $newArr[$newindex]['_type'] = $type->Capacity_En;

                                break;
                            }
                        }
                    }
                } elseif ($i == 3) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['COENo'];
                        $newArr[$newindex]['_issue'] = $capacity['COE_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COE_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COE_Remarks'];

                        foreach ($capacityList as $type) {
                            if ($type->id == $capacity['COEId']) {
                                $newArr[$newindex]['_type'] = $type->Capacity_En;

                                break;
                            }
                        }
                    }
                } elseif ($i == 4) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['GMDSS_NO'];
                        $newArr[$newindex]['_issue'] = $capacity['GMD_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['GMD_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['GMD_Remarks'];
                    }
                } elseif ($i == 5) {
                    if (!empty($capacity) && $capacity != null) {
                        $newArr[$newindex]['_no'] = $capacity['COE_GOCNo'];
                        $newArr[$newindex]['_issue'] = $capacity['COE_GOC_IssuedDate'];
                        $newArr[$newindex]['_expire'] = $capacity['COE_GOC_ExpiryDate'];
                        $newArr[$newindex]['_by'] = $capacity['COE_GOC_Remarks'];
                    }
                } elseif ($i < 15) {
                    if (isset($training[$i - 6])) {
                        $newArr[$newindex]['_no'] = $training[$i - 6]->CertNo;
                        $newArr[$newindex]['_issue'] = $training[$i - 6]->IssueDate;
                        $newArr[$newindex]['_expire'] = $training[$i - 6]->ExpireDate;
                        $newArr[$newindex]['_by'] = $training[$i - 6]->IssuedBy;
                    }
                } else {
                    if (isset($othercert[$i - 15])) {
                        $newArr[$newindex]['_no'] = $othercert[$i - 15]->CertNo;
                        $newArr[$newindex]['_name'] = $othercert[$i - 15]->CertName;
                        $newArr[$newindex]['_issue'] = $othercert[$i - 15]->IssueDate;
                        $newArr[$newindex]['_expire'] = $othercert[$i - 15]->ExpireDate;
                        $newArr[$newindex]['_by'] = $othercert[$i - 15]->IssuedBy;
                        $newArr[$newindex]['title'] = $othercert[$i - 15]->CertName;
                    }
                }

                $newArr[$newindex]['index'] = $i;
                if ($i < 15) {
                    $newArr[$newindex]['title'] = $this->getCertNameByIndex($i);
                }

                if ($newArr[$newindex]['_issue'] == '' || $newArr[$newindex]['_issue'] == null) {
                    unset($newArr[$newindex]);

                    continue;
                }

                if ($expire_days != 0 && $newArr[$newindex]['_expire'] != null) {
                    $datediff = strtotime2($newArr[$newindex]['_expire']) - $today;
                    if (round($datediff / (60 * 60 * 24)) > $expire_days) {
                        unset($newArr[$newindex]);

                        continue;
                    }
                }
                ++$count;
                $newArr[$newindex]['count'] = $count;
                ++$newindex;
            }
            if ($count > 0) {
                ++$totalIndex;
            }
        }
        if ($count == 0) {
            unset($newArr[$newindex]);
        }
        if ($newindex == 0) {
            $newArr = [];
        }

        return $newArr;
    }

    public function getCertNameByIndex($index)
    {
        $securityType = SecurityCert::all();
        if ($index == 0) {
            return 'Seamanbook';
        } elseif ($index == 1) {
            return 'Passport';
        } elseif ($index == 2) {
            return 'COC: Certificate of Competency';
        } elseif ($index == 3) {
            return 'COE: Certificate of Endorsement';
        } elseif ($index == 4) {
            return 'GOC: GMDSS general operator';
        } elseif ($index == 5) {
            return 'GOC Endorsement';
        } elseif ($index < 15) {
            return $securityType[$index - 6]->title;
        }
    }
}
