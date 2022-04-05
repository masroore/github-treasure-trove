<?php

namespace App\Http\Controllers;

use App\Models\Voy;
use Illuminate\Http\Request;

class VoyLogController extends Controller
{
    public function ajaxGetVoyData(Request $request)
    {
        $tbl = new Voy();

        $shipId = $request->get('shipId');
        $voyId = $request->get('voyId');
        $year = $request->get('year');

        $retVal = $tbl->getVoyInfoByYear($shipId, $year);

        return response()->json($retVal);
    }

    public function ajaxGetVoyDatas(Request $request)
    {
        $tbl = new Voy();

        $shipIds = $request->get('shipIds');
        $year = $request->get('year');

        $retVal = [];
        foreach ($shipIds as $id) {
            $retVal[$id] = $tbl->getVoyInfoByYear($id, $year);
        }

        return response()->json($retVal);
    }
}
