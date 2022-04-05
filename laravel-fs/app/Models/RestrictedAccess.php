<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class RestrictedAccess extends Model
{
    use EncryptationId;

    protected $table = 'restricted_accesses';

    protected $fillable = ['id', 'user_id', 'process_id', 'date_in', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'name_process', 'name_user_full'];

    public $timestamps = false;

    public function getNameProcessAttribute()
    {
        return $this->getProcesses->name_process;
    }

    public function getNameUserFullAttribute()
    {
        return $this->getUser->name_user . ' ' . $this->getUser->surname_user;
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getProcesses()
    {
        return $this->belongsTo('App\Models\Process', 'process_id');
    }
}
