<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/7
 * Time: 18:44.
 */

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Litipk\BigNumbers\Decimal;

class Common extends Model
{
    protected $table = 'tb_decision_report';

    protected $_DAY_UNIT = 1000 * 3600;

    public function generateReportID($report_data)
    {
        $retVal = false;

        try {
            DB::beginTransaction();
            DB::table($this->table)->lockForUpdate();
            $year = date('Y', strtotime($report_data));
            $count = self::whereRaw(DB::raw('mid(report_date, 1, 4) like ' . $year))->where('state', '!=', REPORT_STATUS_DRAFT)->orderBy('report_id', 'desc')->first();

            if ($count == null) {
                $count = date('y', strtotime($report_data)) . '0001';

                return $count;
            }
            $count = $count->report_id;
            $tmp = substr($count, 2, strlen($count) - 1);
            if ((int) $tmp >= 9999) {
                DB::rollback();

                return false;
            }

            $count = $count + 1;

            $retVal = $count;

            $is_exist = DB::table($this->table)->where('report_id', $retVal)->first();
            while (true) {
                if ($is_exist != null) {
                    $retVal = $retVal + 1;
                } else {
                    break;
                }
                $is_exist = DB::table($this->table)->where('report_id', $retVal)->first();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return $retVal;
        }

        return $retVal;
    }

    public static function getTermDay($start_date, $end_date, $start_gmt = 0, $end_gmt = 0)
    {
        $_DAY_UNIT = 1000 * 3600;
        $currentDate = strtotime($end_date) * 1000;
        $currentGMT = $_DAY_UNIT * $end_gmt;
        $prevDate = strtotime($start_date) * 1000;
        $prevGMT = $_DAY_UNIT * $start_gmt;
        $diffDay = 0;
        $currentDate = Decimal::create($currentDate - $currentGMT)->div(Decimal::create($_DAY_UNIT));
        $prevDate = Decimal::create($prevDate - $prevGMT)->div(Decimal::create($_DAY_UNIT));
        $diffDay = $currentDate->sub($prevDate)->div(Decimal::create(24))->__toString();

        return round($diffDay, 4);
    }
}
