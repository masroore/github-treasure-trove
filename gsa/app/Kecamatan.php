<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kecamatan extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['nama', 'idkota', 'oa', 'created_by', 'updated_by'];

    protected $table = 'kecamatan';
}
