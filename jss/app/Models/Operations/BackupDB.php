<?php
/**
 * Created by PhpStorm.
 * User: ChoeMunBong
 * Date: 2017/4/16
 * Time: 13:09.
 */

namespace App\Models\Operations;

use Artisan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackupDB extends Model
{
    protected $table = 'tb_system_backup';

    public function addTransaction($params)
    {
        $userInfo = Auth::user();
        $userID = $userInfo->id;

        DB::beginTransaction();

        try {
            $selector = DB::table($this->table)
                ->insert([
                    'user_id' => $userID,
                    'filepath' => $params['filepath'],
                    'filename' => $params['filename'],
                    'datetime' => $params['datetime'],
                ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return -1;
        }

        return 1;
    }

    public function deleteTransaction($params)
    {
        DB::beginTransaction();

        try {
            DB::table($this->table)->where('id', $params['id'])->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return -1;
        }

        return 1;
    }

    public function runBackup($params)
    {
        $result = Artisan::call('backup');

        return [
            'success' => 1,
            'msg' => '',
        ];
    }

    public function runRestore($params)
    {
        $path = $params['path'];

        $result = Artisan::call('restore', ['path' => $path]);

        return [
            'success' => 1,
            'msg' => '',
        ];
    }

    public function getForDatatable($params)
    {
        $selector = DB::table($this->table);

        $selector->select($this->table . '.*', 'tb_users.account', 'tb_users.realname')
            ->leftJoin('tb_users', 'tb_users.id', '=', $this->table . '.user_id')
            ->orderBy('datetime', 'desc');

        $totalCount = $selector->count();
        $recordsFiltered = $selector->count();

        // get records
        $records = $selector->get();

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
            'error' => 0,
        ];
    }
}
