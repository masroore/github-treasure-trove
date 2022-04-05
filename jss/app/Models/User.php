<?php

namespace App\Models;

use Auth;
use Browser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use stdClass;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'tb_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRecvUser($flowType, $reportId): void
    {
        $unit = DB::table('tb_users')
            ->where('id', Auth::user()->id)
            ->select('*')
            ->first()->unit;

        $friends = DB::table('tb_users')
            ->where('unit', $unit)
            ->select('*')
            ->get();

        $friendID = ',';
        if ($flowType == 1) {
            foreach ($friends as $key => $item) {
                $friendID .= $item->id . ',';
            }
        } else {
            $recvUser = DB::table($this->table)
                ->where('isAdmin', 2)
                ->first()->id;

            $friendID .= Auth::user()->id . ',';
            $friendID .= $recvUser . ',';
        }

        DB::table('tb_decision_report')
            ->where('id', $reportId)
            ->update([
                'recvUser' => $friendID,
            ]);
    }

    public static function getSimpleUserList($unit = null, $pos = null, $realname = null, $status = null)
    {
        $query = static::query()->select('tb_users.*', 'tb_pos.title as posTitle', 'tb_unit.title as unitTitle')
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

        //$result = $query->orderBy('tb_unit.orderkey')->orderBy('tb_pos.orderNum')->paginate()->setPath('');
        $result = $query->orderBy('tb_users.pos', 'asc')->paginate()->setPath('');

        return $result;
    }

    public function isAdmin()
    {
        $result = $this->query()
            ->select('tb_users.isAdmin')
            ->where('tb_users.id', $this['id'])
            ->first();

        if (empty($result)) {
            $result = new stdClass();
            $result->isAdmin = 0;
        }

        return $result;
    }

    public static function getRedirectByRole($role)
    {
        if ($role != STAFF_LEVEL_CAPTAIN && $role != STAFF_LEVEL_SHAREHOLDER) {
            return 'home';
        } elseif ($role == STAFF_LEVEL_CAPTAIN) {
            $is_mobile = Browser::isMobile();

            return $is_mobile == true ? '/voy/register' : '/business/dynRecord';
        } elseif ($role == STAFF_LEVEL_SHAREHOLDER) {
            return '/operation/incomeExpense';
        }
    }
}
