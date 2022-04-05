<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use EncryptationId;

    protected $table = 'providers';

    protected $fillable = ['id', 'rif', 'name_provider', 'phone', 'email', 'contact_person', 'position_person', 'status', 'telephone_operator_id', 'state_id', 'municipalitie_id', 'city_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
