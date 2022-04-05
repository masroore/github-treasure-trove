<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use EncryptationId;

    protected $table = 'themes';

    protected $fillable = ['id', 'description', 'class_name'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
