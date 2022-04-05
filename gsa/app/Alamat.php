<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Alamat extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['pelanggan_id', 'alamat', 'kodepos',	'created_by', 'updated_by', 'labelalamat', 'kecamatan', 'oa', 'idkota', 'no_hp', 'nama_penerima'];

    protected $table = 'pelanggan_alamat';
}
