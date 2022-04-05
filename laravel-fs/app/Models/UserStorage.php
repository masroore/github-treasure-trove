<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class UserStorage extends Model
{
    use EncryptationId;

    protected $table = 'user_storages';

    protected $fillable = ['id', 'user_id', 'storage_id'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;

    public function getStorage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
}
