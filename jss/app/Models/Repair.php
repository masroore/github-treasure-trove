<?php

namespace App\Models;

use App\Models\ShipManage\ShipMaterialCategory;
use App\Models\ShipManage\ShipMaterialSubKind;
use App\Models\ShipMember\ShipPosition;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'tb_ship_repair';

    public function getList($params)
    {
        $selector = self::where('ship_id', $params['ship_id'])
            ->orderBy('serial_no', 'asc');

        if (isset($params['status']) && $params['status'] != REPAIR_STATUS_ALL) {
            if ($params['status'] == REPAIR_STATUS_UNCOMPLETE) {
                $selector->whereNull('completed_at');
            } else {
                $selector->whereNotNull('completed_at');
            }
        }

        $year = date('Y');
        $month = '01';
        if (isset($params['year'])) {
            $year = $params['year'];
        }

        if (isset($params['month'])) {
            $month = sprintf('%02d', $params['month']);
        }

        $date = $year . '-' . $month;
        $selector->whereRaw(DB::raw('mid(request_date, 1, 7) like "' . $date . '"'));

        $records = $selector->get();

        return $records;
    }

    public function getSearch($params)
    {
        $selector = self::where('ship_id', $params['ship_id'])
            ->orderBy('serial_no', 'asc');

        if (isset($params['status']) && $params['status'] != REPAIR_STATUS_ALL) {
            if ($params['status'] == REPAIR_STATUS_UNCOMPLETE) {
                $selector->whereNull('completed_at');
            } else {
                $selector->whereNotNull('completed_at');
            }
        }

        $year = date('Y');
        if (isset($params['year'])) {
            $year = $params['year'];
        }

        if (isset($params['month'])) {
            $month = sprintf('%02d', $params['month']);
        } else {
            $month = '';
        }

        if (isset($params['type']) && $params['type'] != 0) {
            $type = $params['type'];
            if ($type == REPAIR_REPORT_TYPE_DEPART) {
                $field = 'department';
            } elseif ($type == REPAIR_REPORT_TYPE_CHARGE) {
                $field = 'charge';
            } else {
                $field = 'type';
            }
        } else {
            $field = '';
        }

        if (isset($params['value']) && $params['value'] != 0) {
            $value = $params['value'];
        } else {
            $value = 0;
        }

        if ($field != '' && $value != 0) {
            $selector->where($field, $value);
        }

        if (!isset($params['init']) || (isset($params['init']) && $params['init'] == false)) {
            if (isset($params['depart']) && $params['depart'] != 0) {
                $selector->where('department', $params['depart']);
            }

            if (isset($params['charge']) && $params['charge'] != 0) {
                $selector->where('charge', $params['charge']);
            }

            if (isset($params['type']) && $params['type'] != 0) {
                $selector->where('type', $params['type']);
            }

            // if(isset($params['status']) && $params['type'] != 0) {
            //     $selector->where('type', $params['type']);
            // }
        }

        $date = $year . '-' . $month;
        if ($month == '') {
            $selector->whereRaw(DB::raw('mid(request_date, 1, 4) like "' . $year . '"'));
        } else {
            $selector->whereRaw(DB::raw('mid(request_date, 1, 7) like "' . $date . '"'));
        }

        $records = $selector->get();

        foreach ($records as $key => $item) {
            $depart = ShipMaterialCategory::find($item->department);
            if ($depart == null) {
                $records[$key]->depart = '';
            } else {
                $records[$key]->department = $depart->name;
            }

            $charge = ShipPosition::find($item->charge);
            if ($charge == null) {
                $records[$key]->charge = '';
            } else {
                $records[$key]->charge = $charge->Abb;
            }

            $type = ShipMaterialSubKind::find($item->type);
            if ($type == null) {
                $records[$key]->type = '';
            } else {
                $records[$key]->type = $type->name;
            }
        }

        return $records;
    }

    public function getReportList($params)
    {
        $shipId = $params['ship_id'];
        $departList = ShipMaterialCategory::orderBy('order_no', 'asc')->get();
        $posList = ShipPosition::orderBy('OrderNo', 'asc')->get();
        $typeList = ShipMaterialSubKind::orderBy('order_no', 'asc')->get();

        if (isset($params['year'])) {
            $year = $params['year'];
        } else {
            $year = date('Y');
        }

        if (isset($params['type'])) {
            $type = $params['type'];
        } else {
            $type = REPAIR_REPORT_TYPE_DEPART;
        }

        if ($type == REPAIR_REPORT_TYPE_DEPART) {
            $field = 'department';
            $list = $departList;
        } elseif ($type == REPAIR_REPORT_TYPE_CHARGE) {
            $field = 'charge';
            $list = $posList;
        } else {
            $field = 'type';
            $list = $typeList;
        }

        $retVal = [];

        foreach ($list as $key => $item) {
            $_total_count = 0;
            $_complete_count = 0;

            if ($field == 'charge') {
                $index = $item->OrderNo;
            } else {
                $index = $item->order_no;
            }

            for ($i = 1; $i <= 12; ++$i ) {
                $date = $year . '-' . sprintf('%02d', $i);

                if ($type == REPAIR_REPORT_TYPE_DEPART) {
                    $field = 'department';
                } elseif ($type == REPAIR_REPORT_TYPE_CHARGE) {
                    $field = 'charge';
                } else {
                    $field = 'type';
                }

                $total_count = self::where('ship_id', $shipId)
                    ->whereRaw(DB::raw('mid(request_date, 1, 7) like "' . $date . '"'))
                    ->where($field, $item->id)
                    ->count('*');

                $_total_count += $total_count;
                $complete_count = self::where('ship_id', $shipId)
                    ->whereRaw(DB::raw('mid(request_date, 1, 7) like "' . $date . '"'))
                    ->where($field, $item->id)
                    ->whereNotNull('completed_at')
                    ->count('*');

                $_complete_count += $complete_count;
                $retVal[$index]['list'][$i] = [$total_count, $complete_count];
            }

            $retVal[$index]['total'] = $_total_count;
            $retVal[$index]['id'] = $item->id;
            $retVal[$index]['complete'] = $_complete_count;

            if ($type == REPAIR_REPORT_TYPE_DEPART) {
                $retVal[$index]['label'] = $item->name;
            } elseif ($type == REPAIR_REPORT_TYPE_CHARGE) {
                $retVal[$index]['label'] = $item->Abb;
            } else {
                $retVal[$index]['label'] = $item->name;
            }
        }

        $_monthTotal = [];
        $_monthComplete = [];

        $_monthTotal[0][0] = 0;
        $_monthTotal[0][1] = 0;
        foreach ($retVal as $key => $item) {
            $_monthTotal[0][0] += $item['total'];
            $_monthTotal[0][1] += $item['complete'];
        }

        for ($i = 1; $i <= 12; ++$i ) {
            $_monthTotal[$i][0] = 0;
            $_monthTotal[$i][1] = 0;
            foreach ($retVal as $key => $item) {
                $_monthTotal[$i][0] += $item['list'][$i][0];
                $_monthTotal[$i][1] += $item['list'][$i][1];
            }
        }

        return [
            'list' => $retVal,
            'total' => $_monthTotal,
        ];
    }

    public function udpateData($params)
    {
        $ids = $params['id'];
        $ship_id = $params['ship_id'];

        try {
            DB::beginTransaction();

            foreach ($ids as $key => $item) {
                if (isset($item) && $item != 0) {
                    $tbl = self::find($item);
                } else {
                    $tbl = new self();
                }

                $tbl['ship_id'] = $ship_id;
                $tbl['serial_no'] = $params['serial_no'][$key] ?? '';
                $tbl['request_date'] = $params['request_date'][$key] ?? null;
                $tbl['department'] = $params['department'][$key] ?? 0;
                $tbl['charge'] = $params['charge'][$key] ?? 0;
                $tbl['type'] = $params['type'][$key] ?? 0;
                $tbl['job_description'] = $params['job_description'][$key] ?? '';
                $tbl['completed_at'] = $params['completed_at'][$key] ?? null;
                $tbl['remark'] = $params['remark'][$key] ?? '';
                $tbl->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }

        return true;
    }

    public function getYearList()
    {
        $yearList = [];
        $info = self::orderBy('request_date', 'asc')->first();
        if ($info == null) {
            $baseYear = date('Y');
        } else {
            $baseYear = substr($info->request_date, 0, 4);
        }

        for ($year = date('Y'); $year >= $baseYear; --$year ) {
            $yearList[] = $year;
        }

        return $yearList;
    }
}
