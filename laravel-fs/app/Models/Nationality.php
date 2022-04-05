<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use EncryptationId;

    protected $table = 'nationalities';

    protected $fillable = ['id', 'name_nationality', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
