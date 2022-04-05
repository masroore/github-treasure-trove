<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/25
 * Time: 9:47.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipMemberTraining extends Model
{
    //protected $table = 'tb_training_registry';
    protected $table = 'tb_ship_training';

    public function security()
    {
        return $this->hasOne('App\Models\ShipMember\SecurityCert', 'id', 'TCP_certID');
    }

    public static function insertMemberTrainning($memberId, $STCW, $CertNo, $CertIssue, $CertExpire, $IssuedBy)
    {
        $result = 0;

        self::where('memberId', $memberId)->delete();
        foreach ($STCW as $index => $data) {
            if ($CertIssue[$index] == '') {
                $CertIssue[$index] = null;
            }
            if ($CertExpire[$index] == '') {
                $CertExpire[$index] = null;
            }
            self::insert(['memberId' => $memberId, 'CertSequence' => $index, 'STCW' => $STCW[$index], 'CertNo' => $CertNo[$index], 'IssueDate' => $CertIssue[$index], 'ExpireDate' => $CertExpire[$index], 'IssuedBy' => $IssuedBy[$index]]);
        }

        return $result;
    }
}
