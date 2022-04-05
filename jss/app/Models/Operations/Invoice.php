<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'tbl_invoice';

    public $timestamps = false;

    public function shipName()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'ShipID');
    }

    public function acItem()
    {
        return $this->hasOne('App\Models\Operations\AcItem', 'id', 'AC_Items');
    }

    public function acItemDetail()
    {
        return $this->hasOne('App\Models\Operations\AcItemDetail', 'id', 'AC_Items');
    }

    public function voyNo()
    {
        return $this->hasOne('App\Models\Operations\CP', 'id', 'Voy');
    }

    public function paidVoyNo()
    {
        return $this->hasOne('App\Models\Operations\CP', 'id', 'Paid_Voy');
    }

    public function accountName()
    {
        return $this->hasOne('App\Models\Operations\Account', 'id', 'Account');
    }

    public static function getInvoiceData($shipId, $s_voy, $e_voy, $ps_voy, $pe_voy, $pay_mode)
    {
        $query = static::query();
        if (!empty($shipId)) {
            $query->where('ShipID', $shipId);
        }
        if (!empty($s_voy)) {
            $query->where('Voy', '>=', $s_voy);
        }
        if (!empty($e_voy)) {
            $query->where('Voy', '<=', $e_voy);
        }
        if (!empty($ps_voy)) {
            $query->where('Paid_Voy', '>=', $ps_voy);
        }
        if (!empty($pe_voy)) {
            $query->where('Paid_Voy', '<=', $pe_voy);
        }
        if (!empty($pay_mode)) {
            $query->where('AC_Items', $pay_mode);
        }

        $result = $query->orderBy('Appl_Date', 'desc')->paginate(10)->setPath('');
        if (!empty($shipId)) {
            $result->appends(['shipId' => $shipId]);
        }
        if (!empty($s_voy)) {
            $result->appends(['firstVoy' => $s_voy]);
        }
        if (!empty($e_voy)) {
            $result->appends(['endVoy' => $e_voy]);
        }
        if (!empty($ps_voy)) {
            $result->appends(['firstPaidVoy' => $ps_voy]);
        }
        if (!empty($pe_voy)) {
            $result->appends(['endPaidVoy' => $pe_voy]);
        }
        if (!empty($pay_mode)) {
            $result->appends(['payMode' => $pay_mode]);
        }

        return $result;
    }

    public function shipSupply()
    {
        return $this->hasMany('App\Models\Operations\ShipSupply', 'INVOICE_ID', 'Ref_No');
    }

    public static function caculateVoyInvoice($voyId)
    {
        $query = 'SELECT
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "FRT" THEN a.Amount ELSE 0 END), 0) AS Frt,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "ADD INCOME" THEN a.Amount ELSE 0 END), 0) AS Add_In,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "Brokerage" THEN a.Amount ELSE 0 END), 0) AS Brokerage,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "PD" THEN a.Amount ELSE 0 END), 0) AS Pda,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "BUNKER" THEN a.Amount ELSE 0 END), 0) AS Bunker,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "S & S" THEN a.Amount ELSE 0 END), 0) AS S_S,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "REPAIR FEE" THEN a.Amount ELSE 0 END), 0) AS Repair_Fee,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "CTM" THEN a.Amount ELSE 0 END), 0) AS CTM,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "INSURANCE" THEN a.Amount ELSE 0 END), 0) AS Insurance,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "ISM FEE" THEN a.Amount ELSE 0 END), 0) AS ISM,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "SUVY FEE" THEN a.Amount ELSE 0 END), 0) AS Suvy_Fee,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "CMM FEE" THEN a.Amount ELSE 0 END), 0) AS CMM_Fee,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "CERT FEE" THEN a.Amount ELSE 0 END), 0) AS Cert_Fee,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "OTHER" THEN a.Amount ELSE 0 END), 0) AS Other,
                    IFNULL(SUM(CASE c.AC_Item_En WHEN "BUDGET" THEN a.Amount ELSE 0 END), 0) AS FRT
                    FROM tbl_invoice a INNER JOIN tbl_ac_detail_item b ON a.AC_Items = b.id
                    INNER JOIN tbl_ac_item c ON b.AC_Item = c.id
                    WHERE a.Voy = ' . $voyId;

        $result = DB::select($query);

        return $result;
    }
}
