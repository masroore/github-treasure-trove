<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/7
 * Time: 18:44.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class UserInfo extends Model
{
    protected $table = 'tb_users';

    public function loginId()
    {
        return $this->hasOne('App\User', 'id', 'id');
    }

    public function position()
    {
        return $this->hasOne('App\Models\Member\Post', 'id', 'pos');
    }

    public function unitName()
    {
        return $this->hasOne('App\Models\Member\Unit', 'id', 'unit');
    }

    public function isAdmin()
    {
        $result = $this->query()
            ->select('tb_users.isAdmin')
            ->join('tb_users', 'tb_users.id', '=', 'tb_users.id')
            ->where('tb_users.id', $this['id'])
            ->first();

        if (empty($result)) {
            $result = new stdClass();
            $result->isAdmin = 0;
        }

        return $result;
    }

    public static function getSimpleUserList($unit = null, $pos = null, $realname = null, $status = null)
    {
        $query = static::query()->select('tb_users.*')
            ->leftJoin('tb_pos', 'tb_users.pos', '=', 'tb_pos.id')
            ->leftJoin('tb_unit', 'tb_users.unit', '=', 'tb_unit.id');

        if (isset($unit)) {
            $query->where('tb_users.unit', $unit);
        }

        if (isset($pos)) {
            $query->where('tb_users.pos', $pos);
        }

        if (isset($realname)) {
            $query->where('tb_users.realname', 'like', '%' . $realname . '%');
        }

        if (isset($status)) {
            $query->where('tb_users.status', $status);
        }

        $result = $query->orderBy('tb_unit.orderkey')->orderBy('tb_pos.orderNum')->paginate()->setPath('');

        return $result;
    }

    public static function getUserSimpleListByUnit($unit = 0)
    {
        $query = static::query()
            ->select('tb_users.realname', 'tb_users.id', 'tb_unit.title', 'tb_pos.title as pos', 'tb_users.releaseDate')
            ->leftJoin('tb_unit', 'tb_users.unit', '=', 'tb_unit.id')
            ->leftJoin('tb_pos', 'tb_users.pos', '=', 'tb_pos.id');

        if ($unit > 0) {
            $query->where('tb_users.unit', $unit);
        }

        $query->orderBy('tb_unit.orderkey')->orderBy('tb_pos.orderNum');

        $result = $query->get();

        return $result;
    }

    public static function getUserListOrderByUnit($status = 1, $isParty = -1, $unit = 0)
    {
        $query = static::query()->leftJoin('tb_unit', 'tb_users.unit', '=', 'tb_unit.id');
        if ($status > -1) {
            $query = $query->where('tb_users.status', $status);
        }
        if ($isParty > -1) {
            $query = $query->where('tb_users.isParty', $isParty);
        }
        if ($unit > 0) {
            $query = $query->where('tb_users.unit', $unit);
        }
        $query = $query->orderBy('tb_unit.orderkey');
        $result = $query->get();

        return $result;
    }
}
