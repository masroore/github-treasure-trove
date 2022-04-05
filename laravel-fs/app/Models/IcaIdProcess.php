<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class IcaIdProcess extends Model
{
    use EncryptationId;

    protected $table = 'ica_id_processes';

    protected $fillable = ['id', 'code', 'description_process', 'status', 'ica_id', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
