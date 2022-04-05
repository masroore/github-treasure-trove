<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShipOilSupply extends Model
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
                sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.QTY else 0 end) as SumFO,
                sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.PRCE else 0 end) as SumPriceFO,
                sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.QTY else 0 end) as SumDO,
                sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.PRCE else 0 end) as SumPriceDO,
                sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.QTY else 0 end) as SumLO,
                sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.PRCE else 0 end) as SumPriceLO,
                Year(tbl_shipsupply.SUPPLD_DATE) as SupplyYear
                FROM tbl_invoice
                INNER JOIN tbl_shipsupply ON tbl_invoice.id=tbl_shipsupply.INVOICE_ID
                WHERE (tbl_shipsupply.AC_ITEM="FO" Or tbl_shipsupply.AC_ITEM="DO" Or tbl_shipsupply.AC_ITEM="LO")
                GROUP BY Year(tbl_shipsupply.SUPPLD_DATE)
                ORDER BY Year(tbl_shipsupply.SUPPLD_DATE)';
        $result = DB::select($query);

        return $result;
    }

    // get supply data of a year
    public static function getDataByYear($year)
    {
        $query = 'SELECT Year(SUPPLD_DATE) AS SupplyYear, Sum(IfNull(FO,0)) AS SHIPYEAR_FO, Sum(IfNull(PriceFO, 0)) AS SHIPYEAR_PRICE_FO,
                Sum(IfNull(DO,0)) AS SHIPYEAR_DO, Sum(IfNull(PriceDO, 0)) AS SHIPYEAR_PRICE_DO,
                Sum(IfNull(LO,0)) AS SHIPYEAR_LO, Sum(IfNull(PriceLO, 0)) AS SHIPYEAR_PRICE_LO,
                tb_ship_register.shipName_Cn, tb_ship_register.RegNo,
                (CASE tb_ship_register.Shipid WHEN "0" THEN 100 ELSE tb_ship_register.Shipid END) as ShipOrder
                FROM (SELECT
                sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.QTY else 0 end) as FO,
                sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.PRCE else 0 end) as PriceFO,
                sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.QTY else 0 end) as DO,
                sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.PRCE else 0 end) as PriceDO,
                sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.QTY else 0 end) as LO,
                sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.PRCE else 0 end) as PriceLO,
                tbl_shipsupply.SUPPLD_DATE, tbl_invoice.ShipID
                FROM tbl_invoice
                INNER JOIN tbl_shipsupply ON tbl_invoice.id=tbl_shipsupply.INVOICE_ID
                WHERE (tbl_shipsupply.AC_ITEM="FO" Or tbl_shipsupply.AC_ITEM="DO" Or tbl_shipsupply.AC_ITEM="LO")
                GROUP BY tbl_shipsupply.SUPPLD_DATE, tbl_invoice.ShipID
                ORDER BY tbl_shipsupply.SUPPLD_DATE) as Qry_BunkerSupply
                JOIN tb_ship_register on tb_ship_register.RegNo = Qry_BunkerSupply.ShipID
                WHERE Year(SUPPLD_DATE) = "' . $year . '"
                GROUP BY Year(SUPPLD_DATE), tb_ship_register.RegNo
                ORDER BY ShipOrder';
        $result = DB::select($query);

        return $result;
    }

    // get supply data of a year by ship name
    public static function getDataByYearAndShip($year, $ship)
    {
        $query = 'SELECT SUPPLD_DATE, FO, PriceFO, DO, PriceDO, LO, PriceLO, tb_ship_register.shipName_Cn, Qry_BunkerSupply.Voy, Qry_BunkerSupply.Discription, Qry_BunkerSupply.Ref_No,tbl_cp.Voy_No
                    FROM (SELECT
                            sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.QTY else 0 end) as FO,
                            sum(case tbl_shipsupply.AC_ITEM when "FO" then tbl_shipsupply.PRCE else 0 end) as PriceFO,
                            sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.QTY else 0 end) as DO,
                            sum(case tbl_shipsupply.AC_ITEM when "DO" then tbl_shipsupply.PRCE else 0 end) as PriceDO,
                            sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.QTY else 0 end) as LO,
                            sum(case tbl_shipsupply.AC_ITEM when "LO" then tbl_shipsupply.PRCE else 0 end) as PriceLO,
                            tbl_shipsupply.SUPPLD_DATE, tbl_invoice.ShipID, tbl_invoice.Voy,tbl_invoice.Discription as Discription,tbl_invoice.Ref_No as Ref_No
                            FROM tbl_invoice
                            INNER JOIN tbl_shipsupply ON tbl_invoice.id=tbl_shipsupply.INVOICE_ID
                            WHERE tbl_invoice.ShipID = "' . $ship . '" AND (tbl_shipsupply.AC_ITEM="FO" OR tbl_shipsupply.AC_ITEM="DO" OR tbl_shipsupply.AC_ITEM="LO")
                            GROUP BY tbl_shipsupply.SUPPLD_DATE) as Qry_BunkerSupply
                    JOIN tb_ship_register on tb_ship_register.RegNo = Qry_BunkerSupply.ShipID
                    JOIN tbl_cp ON tbl_cp.id = Qry_BunkerSupply.Voy
                    WHERE tb_ship_register.RegNo ="' . $ship . '" and Year(SUPPLD_DATE) = "' . $year . '"
                    ORDER BY SUPPLD_DATE';
        $result = DB::select($query);

        return $result;
    }
}
