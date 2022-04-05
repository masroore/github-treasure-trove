<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use EncryptationId;

    protected $table = 'states';

    protected $fillable = ['id', 'name_state', 'country_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];

    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
