<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use EncryptationId;

    protected $table = 'storages';

    protected $fillable = ['id', 'code', 'name_storage', 'phone', 'email', 'status', 'telephone_operator_id', 'type_storage_id', 'bank_id', 'address_id', 'responsible_id', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'bank_name', 'type_storage'];

    public $timestamps = false;

    public function getBankNameAttribute()
    {
        return $this->getBanks->name_bank;
    }

    public function getBanks()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id');
    }

    public function getTypeStorage()
    {
        return $this->belongsTo('App\Models\TypeStorage', 'type_storage_id');
    }

    public function getTypeStorageAttribute()
    {
        return $this->getTypeStorage;
    }

    public function getTelephoneOperator()
    {
        return $this->belongsTo('App\Models\TelephoneOperator', 'telephone_operator_id');
    }
}
