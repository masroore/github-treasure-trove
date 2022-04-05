<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/25
 * Time: 15:09.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipMemberExaming extends Model
{
    protected $table = 'tb_member_examing';

    public static function getMemberMarks($memberIds)
    {
        $result = static::query()
            ->whereIn('tb_member_examing.memberId', $memberIds)
            ->orderBy('memberId')
            ->get();

        return $result;
    }
}
