<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TradeMark extends Model
{
    use EncryptationId;

    protected $table = 'trade_marks';

    protected $fillable = ['id', 'name_trade_mark', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['change_status_marks', 'crypt_id'];

    public function getChangeStatusMarksAttribute()
    {
        $changeMark = '';
        if ($this->status == 1) {
            $changeMark = 'Activo';
        } else {
            $changeMark = 'Inactivo';
        }

        return $changeMark;
    }
}
