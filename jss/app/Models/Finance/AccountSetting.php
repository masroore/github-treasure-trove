<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/12
 * Time: 21:16.
 */

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountSetting extends Model
{
    protected $table = 'tb_accounts_setting';

    public function getForDatatable($params)
    {
        $selector = DB::table($this->table)->select('*');
        $recordsFiltered = $selector->count();
        $records = $selector->get();

        return [
            'draw' => $params['draw'] + 0,
            'recordsTotal' => DB::table($this->table)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
            'error' => 0,
        ];
    }
}
