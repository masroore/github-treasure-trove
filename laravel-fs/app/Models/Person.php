<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use EncryptationId;

    protected $table = 'people';

    protected $fillable = ['id', 'first_name', 'second_name', 'first_surname', 'second_surname', 'date_birth', 'expiration_month', 'expiration_year', 'phone_house', 'phone_cell', 'email', 'telephone_house_operator_id', 'telephone_cell_operator_id', 'gender_id', 'nationality_id', 'client_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'name_gender', 'name_nationality', 'name_telephone_operator_house', 'name_telephone_operator_cell'];

    public function getTelephoneOperatorHouse()
    {
        return $this->belongsTo('App\Models\TelephoneOperator', 'telephone_house_operator_id');
    }

    public function getNameTelephoneOperatorHouseAttribute()
    {
        return $this->getTelephoneOperatorHouse;
    }

    public function getTelephoneOperatorCell()
    {
        return $this->belongsTo('App\Models\TelephoneOperator', 'telephone_cell_operator_id');
    }

    public function getNameTelephoneOperatorCellAttribute()
    {
        return $this->getTelephoneOperatorCell;
    }

    public function getGender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    public function getNameGenderAttribute()
    {
        return $this->getGender;
    }

    public function getNationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id');
    }

    public function getNameNationalityAttribute()
    {
        return $this->getNationality;
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
