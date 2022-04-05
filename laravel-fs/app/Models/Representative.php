<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use EncryptationId;

    protected $table = 'representatives';

    protected $fillable = ['id', 'document', 'first_name', 'second_name', 'first_surname', 'second_surname', 'date_birth', 'expiration_month', 'expiration_year', 'phone', 'email', 'type_document_id', 'gender_id', 'telephone_house_operator_id', 'telephone_cell_operator_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['rif', 'crypt_id', 'name_gender', 'phone_id'];

    public function getRifAttribute()
    {
        return $this->getTypeDocument->abbreviation . '-' . $this->document;
    }

    public function getTypeDocument()
    {
        return $this->belongsTo('App\Models\TypeDocument', 'type_document_id');
    }

    public function getPhoneIdAttribute()
    {
        return $this->getTelephoneOperator->code . '-' . $this->phone;
    }

    public function getGender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    public function getNameGenderAttribute()
    {
        return $this->getGender;
    }

    public function getTelephoneOperator()
    {
        return $this->belongsTo('App\Models\TelephoneOperator', 'telephone_operator_id');
    }
}
