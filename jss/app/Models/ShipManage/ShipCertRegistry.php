<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/14
 * Time: 7:41.
 */

namespace App\Models\ShipManage;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ShipCertRegistry extends Model
{
//    use SoftDeletes;
    protected $table = 'tb_ship_certregistry';
//    protected $date = ['deleted_at'];

    public static function getShipCertList($shipId, $certName, $issuName, $expire)
    {
        $query = static::query()
            ->select(
                'tb_ship_certregistry.id',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                'tb_ship_certlist.CertNo',
                'tb_ship_certlist.CertName_Cn',
                'tb_ship_certlist.CertKind',
                'tb_ship_certregistry.IssuedAdmin_Cn',
                'tb_ship_certregistry.CertLevel',
                'tb_ship_certregistry.IssuedDate',
                'tb_ship_certregistry.ExpiredDate',
                'tb_ship_certregistry.Scan'
            )
            ->join('tb_ship_register', 'tb_ship_certregistry.ShipName', '=', 'tb_ship_register.RegNo')
            ->leftJoin('tb_ship_certlist', 'tb_ship_certregistry.CertNo', '=', 'tb_ship_certlist.CertNo');
        if (!empty($shipId)) {
            $query->where('tb_ship_certregistry.ShipName1', $shipId);
        }

        if (!empty($certName)) {
            $query->where('tb_ship_certlist.CertName_Cn', 'like', '%' . $certName . '%');
        }

        if (!empty($issuName)) {
            $query->where('tb_ship_certregistry.IssuedAdmin_Cn', 'like', '%' . $issuName . '%');
        }

        if (!empty($expire)) {
            $date = new DateTime();
            if ($expire < 13) {
                $day = $expire * 30;
            } elseif ($expire > 12) {
                $day = ($expire - 12) * 365;
            }

            $date->modify("+$day day");
            $expireDate = $date->format('Y-m-d');

            $query->where('tb_ship_certregistry.ExpiredDate', '<', $expireDate);
        }

        $list = $query->orderBy('tb_ship_certlist.CertNo')->get();

        return $list;
    }

    public function getExpiredList($date = 0, $ship_id = '')
    {
        $date = date('Y-m-d', strtotime('+' . $date . ' days'));

        $selector = DB::table($this->table)
            ->where(function ($query) use ($date): void {
                $query->whereRaw(DB::raw('expire_date < ' . "'" . $date . "'"))
                    ->orwhereRaw(DB::raw('due_endorse < ' . "'" . $date . "'"));
            })
            ->whereNotNull('issue_date')
            ->orderBy('cert_id', 'asc')
            ->select('*');

        if ($ship_id != '') {
            $selector->where('ship_id', $ship_id);
        }

        $result = $selector->get();

        $shipReg = new ShipRegister();
        foreach ($result as $key => $item) {
            $result[$key]->shipName = $shipReg->getShipNameByIMO($item->ship_id);
            $certInfo = ShipCertList::where('id', $item->cert_id)->first();
            if ($certInfo == null) {
                $result[$key]->certName = '';
            } else {
                $result[$key]->certName = $certInfo->code;
            }
        }

        return $result;
    }
}
