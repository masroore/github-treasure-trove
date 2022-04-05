<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 4/6/2017
 * Time: 6:13 PM.
 */

namespace App\Models\ShipManage;

use App\Models\Convert\VoySettle;
use App\Models\Operations\Cargo;
use App\Models\Operations\CP;
use App\Models\ShipTechnique\ShipPort;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'tb_ship_register';

    protected $table_cp = 'tbl_cp';

    public function getEvaluationData($shipId, $voyId)
    {
        $retVal['cpInfo'] = [];
        $cpData = CP::where('Ship_ID', $shipId)->where('Voy_No', $voyId)->first();
        if ($cpData == null) {
            $retVal['cpInfo'] = [];
        } else {
            $retVal['cpInfo'] = $cpData;
        }

        if ($cpData != null) {
            $cargoTbl = new Cargo();
            $portTbl = new ShipPort();
            $retVal['cpInfo']['Cargo_Name'] = $cargoTbl->getCargoNames($retVal['cpInfo']['Cargo']);
            $retVal['cpInfo']['lport'] = $portTbl->getPortNames($retVal['cpInfo']['LPort']);
            $retVal['cpInfo']['dport'] = $portTbl->getPortNames($retVal['cpInfo']['DPort']);
        }

        $voySettleTbl = new VoySettle();
        $voyData = $voySettleTbl->getDataForEval($shipId, $voyId);
        $retVal['realInfo'] = $voyData;

        return $retVal;
    }
}
