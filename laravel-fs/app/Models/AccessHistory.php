<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class AccessHistory extends Model
{
    use EncryptationId;

    protected $table = 'access_histories';

    protected $fillable = ['id', 'user_id', 'date_in', 'date_out', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'name_user'];

    public $timestamps = false;

    public function getNameUserAttribute()
    {
        return $this->getUser->name_user . ' ' . $this->getUser->surname_user;
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getImportantSetting()
    {
        return $this->hasMany(ImportantSetting::class, 'access_history_id')->orderBy('id', 'desc');
    }
}
