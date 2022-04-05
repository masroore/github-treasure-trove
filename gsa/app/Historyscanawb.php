<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Historyscanawb extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['tipe', 'idawb', 'iduser', 'created_by', 'updated_by', 'namauser'];

    protected $table = 'history_scan_awb';
}
