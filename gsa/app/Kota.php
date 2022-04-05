<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kota extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['kode',	'nama',	'keterangan', 'created_by', 'updated_by',	'status'];

    protected $table = 'kota';
}
