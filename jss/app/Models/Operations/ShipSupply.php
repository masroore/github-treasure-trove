<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShipSupply extends Model
{
    protected $table = 'tbl_shipsupply';

    public $timestamps = false;

    public function shipName()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'ShipID');
    }

    // get supply data of all years
    public static function getAllData()
    {
        $query = 'SELECT
                sum(case Tbl_ShipSupply.AC_ITEM when "FO" then Tbl_ShipSupply.QTY else 0 end) as SumFO,
                sum(case Tbl_ShipSupply.AC_ITEM when "DO" then Tbl_ShipSupply.QTY else 0 end) as SumDO,
                sum(case Tbl_ShipSupply.AC_ITEM when "LO" then Tbl_ShipSupply.QTY else 0 end) as SumLO,
                Year(Tbl_ShipSupply.SUPPLD_DATE) as SupplyYear
                FROM Tbl_INVOICE
                INNER JOIN Tbl_ShipSupply ON Tbl_INVOICE.Ref_No=Tbl_ShipSupply.INVOICE_ID
                WHERE (Tbl_ShipSupply.AC_ITEM="FO" Or Tbl_ShipSupply.AC_ITEM="DO" Or Tbl_ShipSupply.AC_ITEM="LO")
                GROUP BY Year(Tbl_ShipSupply.SUPPLD_DATE)
                ORDER BY Year(Tbl_ShipSupply.SUPPLD_DATE)';
        $result = DB::select($query);

        return $result;
    }

    // get supply data of a year
    public static function getDataByYear($year)
    {
        $query = 'SELECT Year(SUPPLD_DATE) AS SupplyYear, Sum(IfNull(FO,0)) AS SHIPYEAR_FO, Sum(IfNull(DO,0)) AS SHIPYEAR_DO,
                Sum(IfNull(LO,0)) AS SHIPYEAR_LO, tb_ship_register.shipName_Cn
                FROM (SELECT
                sum(case Tbl_ShipSupply.AC_ITEM when "FO" then Tbl_ShipSupply.QTY else 0 end) as FO,
                sum(case Tbl_ShipSupply.AC_ITEM when "DO" then Tbl_ShipSupply.QTY else 0 end) as DO,
                sum(case Tbl_ShipSupply.AC_ITEM when "LO" then Tbl_ShipSupply.QTY else 0 end) as LO,
                Tbl_ShipSupply.SUPPLD_DATE, Tbl_INVOICE.ShipID
                FROM Tbl_INVOICE
                INNER JOIN Tbl_ShipSupply ON Tbl_INVOICE.Ref_No=Tbl_ShipSupply.INVOICE_ID
                WHERE (Tbl_ShipSupply.AC_ITEM="FO" Or Tbl_ShipSupply.AC_ITEM="DO" Or Tbl_ShipSupply.AC_ITEM="LO")
                GROUP BY Tbl_ShipSupply.SUPPLD_DATE, Tbl_INVOICE.ShipID
                ORDER BY Tbl_ShipSupply.SUPPLD_DATE) as Qry_BunkerSupply
                JOIN tb_ship_register on tb_ship_register.RegNo = Qry_BunkerSupply.ShipID
                WHERE Year(SUPPLD_DATE) = "' . $year . '"
                GROUP BY Year(SUPPLD_DATE), tb_ship_register.RegNo';
        $result = DB::select($query);

        return $result;
    }

    // get supply data of a year by ship name
    public static function getDataByYearAndShip($year, $ship)
    {
        $query = 'SELECT SUPPLD_DATE, FO, DO, LO, tb_ship_register.shipName_Cn
                FROM (SELECT
                sum(case Tbl_ShipSupply.AC_ITEM when "FO" then Tbl_ShipSupply.QTY else 0 end) as FO,
                sum(case Tbl_ShipSupply.AC_ITEM when "DO" then Tbl_ShipSupply.QTY else 0 end) as DO,
                sum(case Tbl_ShipSupply.AC_ITEM when "LO" then Tbl_ShipSupply.QTY else 0 end) as LO,
                Tbl_ShipSupply.SUPPLD_DATE, Tbl_INVOICE.ShipID
                FROM Tbl_INVOICE
                INNER JOIN Tbl_ShipSupply ON Tbl_INVOICE.Ref_No=Tbl_ShipSupply.INVOICE_ID
                WHERE (Tbl_ShipSupply.AC_ITEM="FO" Or Tbl_ShipSupply.AC_ITEM="DO" Or Tbl_ShipSupply.AC_ITEM="LO")
                GROUP BY Tbl_ShipSupply.SUPPLD_DATE, Tbl_INVOICE.ShipID) as Qry_BunkerSupply
                JOIN tb_ship_register on tb_ship_register.RegNo = Qry_BunkerSupply.ShipID
                WHERE tb_ship_register.RegNo ="' . $ship . '" and Year(SUPPLD_DATE) = "' . $year . '"
                ORDER BY SUPPLD_DATE';
        $result = DB::select($query);

        return $result;
    }
}
