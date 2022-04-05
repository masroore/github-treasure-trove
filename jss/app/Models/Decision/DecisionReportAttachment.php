<?php
/**
 * Created by PhpStorm.
 * User: CCJ
 * Date: 4/21/2017
 * Time: 22:28.
 */

namespace App\Models\Decision;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DecisionReportAttachment extends Model
{
    protected $table = 'tb_decision_report_attachment';

    protected $table_report = 'tb_decision_report';

    public function updateAttach($reportId, $fileName, $fileDir, $fileLink)
    {
        if (self::where('reportId', $reportId)->first() != null) {
            self::where('reportId', $reportId)->delete();
        }

        $ret = DB::table($this->table)
            ->insert([
                'reportId' => $reportId,
                'file_name' => $fileName,
                'file_url' => $fileDir,
                'file_link' => $fileLink,
            ]);

        return true;
    }

    public function deleteRecord($id)
    {
        $selector = DB::table($this->table)
            ->where('reportId', $id)
            ->select('*');
        $result = $selector->first();

        if ($result != null) {
            if (file_exists($result->file_url)) {
                @unlink($result->file_url);
            }
        }

        $ret = DB::table($this->table)
            ->where('reportId', $id)
            ->delete();

        return true;
    }

    public function deleteAttach($id)
    {
        $is_exist = self::where('reportId', $id)->first();
        if ($is_exist != null) {
            $file_url = $is_exist->file_url;
            @unlink($file_url);
            self::where('reportId', $id)->delete();
        }

        DB::table($this->table_report)
            ->where('id', $id)
            ->update([
                'attachment' => 0,
            ]);

        return 1;
    }
}
