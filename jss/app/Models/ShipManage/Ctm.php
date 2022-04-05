<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/14
 * Time: 7:41.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ctm extends Model
{
    protected $table = 'tb_ctm';

    public function getYearList($shipId)
    {
        $yearList = [];
        $shipInfo = ShipRegister::where('IMO_No', $shipId)->first();
        if ($shipInfo == null) {
            $baseYear = date('Y');
        } else {
            $baseYear = substr($shipInfo->RegDate, 0, 4);
        }

        for ($year = date('Y'); $year >= $baseYear; --$year ) {
            $yearList[] = $year;
        }

        return $yearList;
    }

    public function getCtmTotal($shipId, $year)
    {
        $monthList = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $retVal = [];
        foreach ($monthList as $item) {
            $tmpYear = $year . '-' . sprintf('%02d', $item);
            $selector = DB::table($this->table)
                ->where('shipId', $shipId)
                ->where('ctm_type', 'CNY')
                ->whereRaw(DB::raw('mid(reg_date, 1, 7) like "' . $tmpYear . '"'))
                ->selectRaw('sum(credit) as credit, sum(debit) as debit, sum(ex_debit) as usd_debit');
            $record = $selector->first();
            $retVal[$item]['CNY'] = $record;

            $selector = DB::table($this->table)
                ->where('shipId', $shipId)
                ->where('ctm_type', 'USD')
                ->whereRaw(DB::raw('mid(reg_date, 1, 7) like "' . $tmpYear . '"'))
                ->selectRaw('sum(credit) as credit, sum(debit) as debit');
            $record = $selector->first();
            $retVal[$item]['USD'] = $record;
        }

        return $retVal;
    }

    public function getCtmDebit($shipId, $year)
    {
        $profitData = g_enum('ProfitDebitData');
        $monthList = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $retVal = [];
        foreach ($profitData as $item => $info) {
            $total = 0;
            foreach ($monthList as $key) {
                $retVal[$key][$item] = 0;
                $tmpYear = $year . '-' . sprintf('%02d', $key);
                $selector = DB::table($this->table)
                    ->where('shipId', $shipId)
                    ->where('ctm_type', 'CNY')
                    ->where('profit_type', $item)
                    ->whereRaw(DB::raw('mid(reg_date, 1, 7) like "' . $tmpYear . '"'))
                    ->selectRaw('sum(ex_debit) as debit');
                $record = $selector->first();
                if ($record != null) {
                    $retVal[$key][$item] += $record->debit;
                }

                $selector = DB::table($this->table)
                    ->where('shipId', $shipId)
                    ->where('ctm_type', 'USD')
                    ->where('profit_type', $item)
                    ->whereRaw(DB::raw('mid(reg_date, 1, 7) like "' . $tmpYear . '"'))
                    ->selectRaw('sum(debit) as debit');
                $record = $selector->first();
                if ($record != null) {
                    $retVal[$key][$item] += $record->debit;
                }
            }
        }

        $totalDebit = 0;
        foreach ($retVal as $key => $item) {
            $retVal[$key]['debitTotal'] = 0;
            foreach ($item as $info) {
                $retVal[$key]['debitTotal'] += $info;
            }

            $totalDebit += $retVal[$key]['debitTotal'];
        }

        $total = [];
        foreach ($profitData as $key => $item) {
            $tmp = 0;
            foreach ($monthList as $info) {
                $tmp += $retVal[$info][$key];
            }

            $total[$key] = $tmp;
        }

        $total[1] = $totalDebit;

        $retArray['list'] = $retVal;
        $retArray['total'] = $total;

        return $retArray;
    }
}
