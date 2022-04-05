<?php

namespace App\Models;

use App\Traits\EncryptationId;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use EncryptationId;

    protected $table = 'banks';

    protected $fillable = ['id', 'code', 'document', 'name_bank', 'name_fantasy', 'phone', 'email', 'status', 'type_document_id', 'phone_operator_id'];

    protected $connection = 'mysql';

    protected $appends = ['country', 'ica', 'crypt_id'];

    public $timestamps = false;

    public function getCountryAttribute()
    {
        return $this->getCountry;
    }

    public function getIcaAttribute()
    {
        return $this->getIca;
    }

    public function getCountry()
    {
        return $this->hasMany(TelephoneOperator::class, 'id', 'country_id');
    }

    public function getIca()
    {
        return $this->hasMany(Ica::class, 'bank_id');
    }

    public function getstorage()
    {
        return $this->hasMany(Storage::class, 'bank_id');
    }
}
