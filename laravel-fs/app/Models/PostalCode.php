<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    use EncryptationId;

    protected $table = 'postal_codes';

    protected $fillable = ['id', 'code', 'state_id', 'user_id', 'date_register', 'ip'];

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
