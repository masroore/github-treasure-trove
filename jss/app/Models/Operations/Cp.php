<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cp extends Model
{
    protected $table = 'tbl_cp';

    protected $table_register = 'tb_ship_register';

    public $timestamps = false;

    public function shipName()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'Ship_ID');
    }

    public function lPortName()
    {
        if (empty($this->LPort)) {
            return '';
        }

        $query = 'SELECT GROUP_CONCAT(Port_Cn) as portName FROM tbl_port WHERE id in (' . $this->LPort . ')';
        $result = DB::select($query);
        if (count($result)) {
            $result = str_replace(',', '=>', $result[0]->portName);
        } else {
            $result = '';
        }

        return $result;
    }

    public function dPortName()
    {
        if (empty($this->DPort)) {
            return '';
        }
        $query = 'SELECT GROUP_CONCAT(Port_Cn) as portName FROM tbl_port WHERE id in (' . $this->DPort . ')';
        $result = DB::select($query);
        if (count($result)) {
            $result = str_replace(',', '=>', $result[0]->portName);
        } else {
            $result = '';
        }

        return $result;
    }

    public function carGoName()
    {
        if (empty($this->Cargo)) {
            return '';
        }
        if (strpos($this->Cargo, ',') > -1) {
            $cargoId = substr($this->Cargo, 1, strlen($this->Cargo) - 2);
        } else {
            $cargoId = $this->Cargo;
        }
        $query = 'SELECT GROUP_CONCAT(CARGO_Cn) as cargoName FROM tbl_cargo WHERE id in (' . $cargoId . ')';
        $result = DB::select($query);
        if (count($result)) {
            $result = $result[0]->cargoName;
        } else {
            $result = '';
        }

        return $result;
    }

    public function typeName()
    {
        return $this->hasOne('App\Models\Operations\Cp_kind', 'id', 'CP_kind');
    }

    public static function getShipCalcData($shipID, $voyId)
    {
        $result = static::query()
            ->select('tbl_cp.*', 'tbl_cargo.CARGO_Cn')
            ->join('tbl_cargo', 'tbl_cp.Cargo', '=', 'tbl_cargo.id')
            ->where('tbl_cp.Ship_ID', $shipID)
            ->where('tbl_cp.id', $voyId)
            ->first();

        return $result;
    }

    public static function getInviceOfCalcData($voyId)
    {
        $query = 'SELECT tbl_invoice.*, tbl_ac_item.C_D FROM tbl_invoice
                    INNER JOIN tbl_ac_detail_item ON tbl_ac_detail_item.id = tbl_invoice.AC_Items
                    INNER JOIN tbl_ac_item ON tbl_ac_item.id = tbl_ac_detail_item.AC_Item
                    INNER JOIN tbl_account on tbl_invoice.Account = tbl_account.id
                    WHERE tbl_invoice.Object = "Business" AND tbl_invoice.Completion = 1 AND tbl_account.isUse = 1 AND tbl_invoice.Paid_Voy = ' . $voyId . '
                    ORDER BY tbl_ac_item.id, tbl_invoice.id';

        $result = DB::select($query);

        return $result;
    }

    public static function getVoyNosOfShip($shipID = '(BULE YORAL)')
    {
        // get VoyNo list of the ship
        if ($shipID == '') {
            return [];
        }

        $result = static::query()
            ->select('id', 'Voy_No', 'CP_No')
            ->where('Ship_ID', $shipID)
            ->orderBy(DB::raw('CONVERT(Voy_No , DECIMAL(4,0))'), 'DESC')
            ->get();

        return $result;
    }

    public static function getReference($shipID)
    {
        if ($shipID == '') {
            return [];
        }

        $result = static::query()
            ->select(DB::raw('max(total_Freight)', 'Voy_No', 'CP_kind'))
            ->where('Ship_ID', $shipID)
            ->orderBy(DB::raw('CONVERT(Voy_No , DECIMAL(4,0))'), 'DESC')
            ->get();

        return $result;
    }

    public function getContractInfo($shipId, $voyId)
    {
        $selector = self::where('Ship_ID', $shipId)
            ->where('Voy_No', $voyId)
            ->select();

        $result = $selector->first();

        if ($result == null) {
            return [];
        }

        return $result;
    }

    public static function getYearList($shipId)
    {
        $yearList = [];
        $info = DB::table('tb_ship_register')->where('IMO_No', $shipId)->first();
        if ($info == null) {
            $baseYear = date('Y');
        } else {
            $baseYear = substr($info->RegDate, 0, 4);
        }

        for ($year = date('Y'); $year >= $baseYear; --$year ) {
            $yearList[] = $year;
        }

        return $yearList;
    }

    public static function getCpList($shipId, $year)
    {
        $info = self::orderBy('Voy_No', 'asc')->where('Ship_ID', $shipId)->whereRaw(DB::raw('mid(Voy_No, 1, 2) like ' . substr($year, -2)))->get();

        if (!isset($info) || count($info) == 0) {
            return [];
        }

        return $info;
    }
}
