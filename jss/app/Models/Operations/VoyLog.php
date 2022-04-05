<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class VoyLog extends Model
{
    protected $table = 'tbl_voy_log';

    public function voyStatus()
    {
        return $this->hasOne('App\Models\Operations\VoyStatus', 'ID', 'Voy_Status');
    }

    public function voyCP()
    {
        return $this->hasOne('App\Models\Operations\CP', 'id', 'CP_ID');
    }

    public function voyClass()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'Ship_ID');
    }

    public static function getShipPositionList()
    {
        $result = DB::table('tbl_voy_log')
            ->select('Ship_Position')
            ->groupBy('Ship_Position')
            ->orderBy('Ship_Position', 'desc')
            ->get();

        return $result;
    }

    public static function getShipVoyLogData($shipID, $voy_No)
    {
        $result = DB::table('tbl_voy_log')
            ->select('tbl_voy_log.*', 'tbl_voy_status.Voy_Status as Voy_St', 'tbl_voy_status.Status_Name', 'tbl_cp.Voy_No', 'tb_ship_register.shipName_Cn')
            ->join('tbl_cp', 'tbl_voy_log.CP_ID', '=', 'tbl_cp.id')
            ->join('tbl_voy_status', 'tbl_voy_log.Voy_Status', '=', 'tbl_voy_status.ID')
            ->join('tb_ship_register', 'tbl_voy_log.Ship_ID', '=', 'tb_ship_register.RegNo')
            ->where('tbl_voy_log.CP_ID', $voy_No)
            ->orderBy('tbl_voy_log.Voy_Date')
            ->get();

        return $result;
    }

    public static function getHomeShipVoyLogData()
    {
        $query = 'SELECT voy_log.*, tbl_voy_status.Voy_Status AS Voy_St, tbl_voy_status.Status_Name, tbl_cp.Voy_No, tb_ship_register.shipName_Cn, tb_ship_register.RegNo, tb_ship_register.id
                    FROM (SELECT * FROM (SELECT * FROM tbl_voy_log ORDER BY Voy_Date DESC) AS tmp GROUP BY Ship_id) AS voy_log
                    INNER JOIN tbl_cp ON voy_log.CP_ID = tbl_cp.id
                    INNER JOIN tbl_voy_status ON voy_log.Voy_Status = tbl_voy_status.ID
                    INNER JOIN tb_ship_register ON voy_log.Ship_ID = tb_ship_register.RegNo
                    JOIN tb_ship ON tb_ship.id = tb_ship_register.Shipid';
        $result = DB::select($query);

        return $result;
    }

    public static function getShipVoyLogDataExcel($shipID, $voy_No)
    {
        $result = DB::table('tbl_voy_log')
            ->select('tbl_voy_log.*', 'tbl_voy_status.Voy_Status as Voy_St', 'tbl_voy_status.Status_Name', 'tbl_cp.Voy_No', 'tb_ship_register.shipName_Cn')
            ->join('tbl_cp', 'tbl_voy_log.CP_ID', '=', 'tbl_cp.id')
            ->join('tbl_voy_status', 'tbl_voy_log.Voy_Status', '=', 'tbl_voy_status.ID')
            ->join('tb_ship_register', 'tbl_voy_log.Ship_ID', '=', 'tb_ship_register.RegNo')
            ->where('tbl_voy_log.CP_ID', $voy_No)
            ->orderBy('tbl_voy_log.Voy_Date')
            ->get();

        return $result;
    }

    public static function addShipMovement($data): void
    {
    }

    public static function getShipVoyInfo($shipId, $page = 0, $firstVoyId = 0, $endVoyId = 0)
    {
        $query = 'SELECT  tb_ship_register.shipName_Cn, tbl_cp.id, tbl_cp.Voy_No, tbl_cp.LPort, tbl_cp.DPort, StartDate, LastDate,
	                      IFNULL(QryVoy_Distance.SailDistance, 0) AS SailDistance,
                          IFNULL(ROUND(((UNIX_TIMESTAMP(LastDate)- UNIX_TIMESTAMP(StartDate)) / 86400), 2), 0) AS DateInteval
                    FROM (tb_ship_register INNER JOIN (tbl_cp
                            LEFT JOIN (SELECT CP_ID, MIN(Voy_Date) AS StartDate, MAX(Voy_Date) AS LastDate
                                                FROM tbl_voy_log GROUP BY CP_ID ORDER BY CP_ID, MIN(Voy_Date)) AS QryVoy_StartLast
                                                ON tbl_cp.id = QryVoy_StartLast.CP_ID
                                    LEFT JOIN (SELECT tbl_voy_log.CP_ID, SUM(ROUND(tbl_voy_log.Sail_Distance, 0)) AS SailDistance
                                                FROM tbl_voy_log
                                                GROUP BY CP_ID) AS QryVoy_Distance ON  tbl_cp.id = QryVoy_Distance.CP_ID)
                    ON tb_ship_register.RegNo = tbl_cp.Ship_ID)
                    WHERE tb_ship_register.RegNo = "' . $shipId . '"';
        if (!empty($firstVoyId) && !empty($endVoyId) && ($endVoyId - $firstVoyId) >= 0) {
            $query .= ' AND tbl_cp.id >= ' . $firstVoyId . ' AND tbl_cp.id <= ' . $endVoyId;
        }
        $query .= ' ORDER BY tbl_cp.id DESC ';

        $result = DB::select($query);

        return $result;
    }

    public static function countShipVoyInfoList($shipId, $firstVoyId = 0, $endVoyId = 0)
    {
        $query = 'SELECT  COUNT(tbl_cp.id) AS totalCount
                    FROM (tb_ship_register INNER JOIN (tbl_cp
                            LEFT JOIN (SELECT CP_ID, MIN(Voy_Date) AS StartDate, MAX(Voy_Date) AS LastDate
                                                FROM tbl_voy_log GROUP BY CP_ID ORDER BY CP_ID, MIN(Voy_Date)) AS QryVoy_StartLast
                                                ON tbl_cp.id = QryVoy_StartLast.CP_ID
                                    LEFT JOIN (SELECT tbl_voy_log.CP_ID, SUM(ROUND(tbl_voy_log.Sail_Distance, 0)) AS SailDistance
                                                FROM tbl_voy_log
                                                GROUP BY CP_ID) AS QryVoy_Distance ON  tbl_cp.id = QryVoy_Distance.CP_ID)
                    ON tb_ship_register.RegNo = tbl_cp.Ship_ID)
                    WHERE tb_ship_register.RegNo = "' . $shipId . '"';
        if (!empty($firstVoyId) && !empty($endVoyId) && ($endVoyId - $firstVoyId) >= 0) {
            $query .= ' AND tbl_cp.id >= ' . $firstVoyId . ' AND tbl_cp.id <= ' . $endVoyId;
        }
        $query .= ' ORDER BY tbl_cp.id DESC';

        $result = DB::select($query);

        $page = 0;
        if (count($result) > 0) {
            $totalCount = $result[0]->totalCount;
            $page = floor($totalCount / 15);
            $remain = fmod($totalCount, 15);
            if ($remain > 0) {
                ++$page;
            }

            return $page;
        }

        return $page;
    }

    public static function getShipVoyAnalysis($shipId, $cpArrayStr)
    {
        if (empty($cpArrayStr)) {
            return null;
        }

        $query = 'SELECT economy.* FROM tbl_cp
                    LEFT JOIN (
                    SELECT tbl_voy_log.CP_ID, SUM(tbl_voy_log.timesum) AS time_sum, tbl_voy_status_event.Event FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_Economy = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event LIKE "%Stop%" AND tbl_voy_log.Ship_ID = "' . $shipId . '"
                    GROUP BY tbl_voy_log.CP_ID, tbl_voy_status_event.Event
                    UNION
                    SELECT tbl_voy_log.CP_ID, SUM(tbl_voy_log.timesum), tbl_voy_status_event.Event FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_UnEconomy = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event LIKE "%Stop%" AND tbl_voy_log.Ship_ID = "' . $shipId . '"
                    GROUP BY tbl_voy_log.CP_ID, tbl_voy_status_event.Event
                    UNION
                    SELECT tbl_voy_log.CP_ID, SUM(tbl_voy_log.timesum), tbl_voy_status_event.Event FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_Other = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event LIKE "%Stop%" AND tbl_voy_log.Ship_ID = "' . $shipId . '"
                    GROUP BY tbl_voy_log.CP_ID, tbl_voy_status_event.Event) AS economy ON tbl_cp.id = economy.CP_ID
                    WHERE CP_ID IN (' . $cpArrayStr . ')
                    ORDER BY economy.CP_ID DESC';

        $result = DB::select($query);

        return $result;
    }

    public static function getSailTime($voyId)
    {
        $timeInfo = new stdClass();
        $timeInfo->DateInteval = 0;
        $timeInfo->SailTime = 0;
        $timeInfo->L_Time = 0;
        $timeInfo->D_Time = 0;

        $query = 'SELECT IFNULL(ROUND(((UNIX_TIMESTAMP(LastDate)- UNIX_TIMESTAMP(StartDate)) / 86400), 2), 0) AS DateInteval
                    FROM (SELECT CP_ID, MIN(Voy_Date) AS StartDate, MAX(Voy_Date) AS LastDate
                                                FROM tbl_voy_log WHERE CP_ID = ' . $voyId . ' ORDER BY Voy_Date) AS QryVoy_StartLast';
        $result = DB::select($query);
        if (count($result)) {
            $timeInfo->DateInteval = $result[0]->DateInteval;
        }

        $query = 'SELECT SUM(tbl_voy_log.timesum) AS time_sum FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_Economy = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event = "SailStop" AND tbl_voy_log.CP_ID = ' . $voyId;
        $result = DB::select($query);
        if (count($result)) {
            $timeInfo->SailTime = $result[0]->time_sum;
        }

        $query = 'SELECT SUM(tbl_voy_log.timesum) AS time_sum FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_Economy = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event = "LoadStop" AND tbl_voy_log.CP_ID = ' . $voyId;
        $result = DB::select($query);
        if (count($result)) {
            $timeInfo->L_Time = $result[0]->time_sum;
        }

        $query = 'SELECT SUM(tbl_voy_log.timesum) AS time_sum FROM tbl_voy_log
                    JOIN tbl_voy_status ON tbl_voy_log.Voy_Status = tbl_voy_status.id
                    JOIN tbl_voy_status_event ON tbl_voy_status.Related_Economy = tbl_voy_status_event.id
                    WHERE tbl_voy_status_event.Event = "DischStop" AND tbl_voy_log.CP_ID = ' . $voyId;
        $result = DB::select($query);
        if (count($result)) {
            $timeInfo->D_Time = $result[0]->time_sum;
        }

        return $timeInfo;
    }
}
