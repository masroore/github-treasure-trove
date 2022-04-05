<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use EncryptationId;

    protected $table = 'countries';

    protected $fillable = ['id', 'code', 'name_country', 'abbreviation', 'code_phone'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;

    public function getListTelephoneOperators()
    {
        return $this->getTelephoneOperators;
    }

    public function getTelephoneOperators()
    {
        return $this->hasMany(TelephoneOperator::class, 'country_id');
    }

    public function getState()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}
