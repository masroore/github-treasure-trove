<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use EncryptationId;

    protected $table = 'municipalities';

    protected $fillable = ['id', 'name_municipality', 'state_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];

    public function getState()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
