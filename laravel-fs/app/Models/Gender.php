<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use EncryptationId;

    protected $table = 'genders';

    protected $fillable = ['id', 'name_gender', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
