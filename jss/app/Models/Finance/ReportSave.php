<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/12
 * Time: 21:16.
 */

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class ReportSave extends Model
{
    protected $table = 'tb_decision_report_save';

    public function getServiceAmount($shipId, $voyId)
    {
        $record = self::where('flowid', REPORT_TYPE_EVIDENCE_OUT)
            ->where('shipNo', $shipId)
            ->where('voyNo', $voyId)
            ->where('profit_type', OUTCOME_FEE6)
            ->selectRaw('sum(CASE WHEN currency="CNY" THEN amount/rate ELSE amount END) as sum');
        $record = $record->first();
        if ($record == null || $record->sum == null) {
            return 0;
        }

        return $record->sum;
    }
}
