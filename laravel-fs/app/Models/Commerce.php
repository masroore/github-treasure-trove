<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    use EncryptationId;

    protected $table = 'commerces';

    protected $fillable = ['id', 'business_name', 'trade_name', 'email', 'phone', 'telephone_operator_id', 'franchise_id', 'client_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'name_telephone_operator', 'name_franchise'];

    public function getTelephoneOperator()
    {
        return $this->belongsTo('App\Models\TelephoneOperator', 'telephone_operator_id');
    }

    public function getNameTelephoneOperatorAttribute()
    {
        return $this->getTelephoneOperator;
    }

    public function getFranchise()
    {
        return $this->belongsTo('App\Models\Franchise', 'franchise_id');
    }

    public function getNameFranchiseAttribute()
    {
        return $this->getFranchise;
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
