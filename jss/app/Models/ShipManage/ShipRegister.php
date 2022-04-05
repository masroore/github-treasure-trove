<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 4/6/2017
 * Time: 6:13 PM.
 */

namespace App\Models\ShipManage;

use App\Models\ShipMember\ShipMember;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class ShipRegister extends Model
{
    protected $table = 'tb_ship_register';

    public static function getSimpleDataList()
    {
        $infoList = static::query()
            ->select(
                'tb_ship_register.id',
                'tb_ship.name',
                'tb_ship_type.ShipType_Cn',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                'tb_ship_register.Class',
                'tb_ship_register.IMO_No',
                'tb_ship_register.Flag_Cn',
                'tb_ship_register.Displacement',
                DB::raw('IFNULL(tb_ship.id, 100) as orderNum')
            )
            ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
            ->join('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
            ->orderby('orderNum')
            ->paginate(10);

        return $infoList;
    }

    public static function getSimpleDataListExcel()
    {
        $infoList = static::query()
            ->select(
                'tb_ship_register.id',
                'tb_ship.name',
                'tb_ship_type.ShipType_Cn',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                'tb_ship_register.Class',
                'tb_ship_register.IMO_No',
                'tb_ship_register.Flag_Cn',
                'tb_ship_register.Displacement'
            )
            ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
            ->join('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
            ->orderby('tb_ship_register.id')
            ->get();

        return $infoList;
    }

    public static function getShipListByOrigin()
    {
        $list = static::query()
            ->select(
                'tb_ship_register.RegNo',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                'tb_ship_register.id as shipID',
                'tb_ship.id',
                'tb_ship.name',
                'tb_ship_register.Speed',
                DB::raw('IFNULL(tb_ship.id, 100) as orderNum')
            )
            ->leftJoin('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
            ->orderby('tb_ship_register.order')
            ->get();

        return $list;
    }

    public static function getShipListOnlyOrigin()
    {
        $list = static::query()
            ->select('tb_ship_register.RegNo', 'tb_ship_register.shipName_Cn', 'tb_ship_register.shipName_En', 'tb_ship_register.id as regId', 'tb_ship.id', 'tb_ship.name')
            ->join('tb_ship', 'tb_ship.id', '=', 'tb_ship_register.Shipid')
            ->orderBy('tb_ship.name')
            ->orderBy('tb_ship_register.id')
            ->get();

        return $list;
    }

    public static function getShipFullName($shipId)
    {
        $nameInfo = static::query()
            ->select('tb_ship_register.shipName_Cn', 'tb_ship_register.shipName_En', 'tb_ship_register.RegNo', 'tb_ship.name')
            ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
            ->where('tb_ship_register.id', $shipId)
            ->first();

        return $nameInfo;
    }

    public static function getShipFullNameByRegNo($shipReg)
    {
        $nameInfo = static::query()
            ->select('tb_ship_register.shipName_Cn', 'tb_ship_register.shipName_En', 'tb_ship_register.RegNo', 'tb_ship.name')
            ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
            ->where('tb_ship_register.RegNo', $shipReg)
            ->first();

        return $nameInfo;
    }

    public static function getShipFullNameByOriginId($shipId)
    {
        $nameInfo = static::query()
            ->select('tb_ship_register.shipName_Cn', 'tb_ship_register.shipName_En', 'tb_ship_register.RegNo', 'tb_ship.name')
            ->leftJoin('tb_ship', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
            ->where('tb_ship.id', $shipId)
            ->first();

        return $nameInfo;
    }

    public function saveShipGeneralData($params, $shipData): void
    {
    }

    public function getShipForExcel($ship_id, $cert_excel_list)
    {
        $retVal['cert'] = [];
        $retVal['member'] = [];
        $shipInfo = self::where('id', $ship_id)->first();
        $imo_no = $shipInfo->IMO_No;

        foreach ($cert_excel_list as $key => $item) {
            $certItem = ShipCertList::where('code', $item[1])->first();
            if ($certItem == null || $certItem == false) {
                $retVal['cert'][$item[0]]['issue_date'] = '';
                $retVal['cert'][$item[0]]['expire_date'] = '';
            } else {
                $shipCertInfo = ShipCertRegistry::where('cert_id', $certItem->id)->where('ship_id', $imo_no)->first();
                if ($shipCertInfo == null || $shipCertInfo == false) {
                    $retVal['cert'][$item[0]]['issue_date'] = '';
                    $retVal['cert'][$item[0]]['expire_date'] = '';
                } else {
                    $retVal['cert'][$item[0]]['issue_date'] = $shipCertInfo->issue_date;
                    $retVal['cert'][$item[0]]['expire_date'] = $shipCertInfo->expire_date;
                }
            }
        }

        // Get MemberInfo for excel
        $shipMemberTbl = new ShipMember();
        $retVal['member'] = $shipMemberTbl->getCertlistByShipId($imo_no);

        return $retVal;
    }

    public function getShipNameByIMO($shipId)
    {
        $info = self::where('IMO_No', $shipId)
            ->first();

        if ($info == null) {
            return '';
        }

        return $info->NickName != '' && $info->NickName != null ? $info->NickName : $info->shipName_En;
    }

    public static function getShipForHolder()
    {
        $ids = Auth::user()->shipList;
        $ids = explode(',', $ids);
        $records = self::whereIn('IMO_No', $ids)->where('RegStatus', '!=', 3)->get();

        return $records;
    }

    public static function getShipForHolderWithDelete()
    {
        $ids = Auth::user()->shipList;
        $ids = explode(',', $ids);
        $records = self::whereIn('IMO_No', $ids)->get();

        return $records;
    }
}
