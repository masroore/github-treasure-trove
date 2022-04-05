<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use EncryptationId;

    protected $table = 'clients';

    protected $fillable = ['document', 'status', 'type_document_id', 'operative_id', 'storage_id', 'user_id', 'date_register', 'ip'];

    protected $hidden = ['id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    private $RepresentativeLegal = 1;

    private $RepresentativeCommerce = 2;

    protected $appends = ['crypt_id', 'name_type_document', 'name_operative', 'name_storage', 'user_username', 'client_address', 'person', 'rif', 'name_client', 'economic_activity', 'miscellaneous', 'code_accounts', 'client_representative', 'client_representative_legal', 'client_representative_commerce'];

    public function getNameTypeDocumentAttribute()
    {
        return $this->getTypeDocument->name_document;
    }

    public function getNameOperativeAttribute()
    {
        return $this->getOperative->name_operative;
    }

    public function getNameStorageAttribute()
    {
        return $this->getStorage->name_storage;
    }

    public function getUserUsernameAttribute()
    {
        return $this->getUser->username;
    }

    public function getClientAddressAttribute()
    {
        return $this->getClientAddress;
    }

    public function getEconomicActivityAttribute()
    {
        return $this->getEconomicActivity;
    }

    public function getMiscellaneousAttribute()
    {
        return $this->getMiscellaneous;
    }

    public function getClientRepresentativeAttribute()
    {
        return $this->getClientRepresentative;
    }

    public function getClientRepresentativeLegalAttribute()
    {
        $getClientRepresentative = $this->getClientRepresentative;
        $RepLegal = [];
        foreach ($getClientRepresentative as $value) {
            if ($value->type_representative_id == $this->RepresentativeLegal) {
                $RepLegal = $value;

                break;
            }
        }

        return $RepLegal;
    }

    public function getClientRepresentativeCommerceAttribute()
    {
        $getClientRepresentative = $this->getClientRepresentative;
        $RepCommerce = [];
        foreach ($getClientRepresentative as $value) {
            if ($value->type_representative_id == $this->RepresentativeCommerce) {
                $RepCommerce = $value;

                break;
            }
        }

        return $RepCommerce;
    }

    public function getPersonAttribute()
    {
        return $this->getPerson;
    }

    public function getRifAttribute()
    {
        return $this->getTypeDocument->abbreviation . '-' . $this->document;
    }

    public function getnameClientAttribute()
    {
        if ($this->getTypeDocument->type_client_id == 1) {//if is person natural
            return mb_strtoupper($this->getPerson->first_name . ' ' . $this->getPerson->second_name . ' ' . $this->getPerson->first_surname . ' ' . $this->getPerson->second_name, 'UTF8');
            //return "Hola";
        }  //if is person juridic
            //return "Hola2";
            return mb_strtoupper($this->getCommerce->business_name, 'UTF8');
    }

    public function getCodeAccountsAttribute()
    {
        return $this->getCodeAccounts;
    }

    public function getTypeDocument()
    {
        return $this->belongsTo('App\Models\TypeDocument', 'type_document_id');
    }

    public function getOperative()
    {
        return $this->belongsTo('App\Models\Operative', 'operative_id');
    }

    public function getStorage()
    {
        return $this->belongsTo('App\Models\Storage', 'storage_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getClientRepresentative()
    {
        return $this->hasMany(ClientRepresentative::class, 'client_id');
    }

    public function getCommerce()
    {
        return $this->hasOne(Commerce::class, 'client_id');
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, 'client_id');
    }

    public function getClientAddress()
    {
        return $this->hasOne(ClientAddress::class, 'client_id');
    }

    public function getEconomicActivity()
    {
        return $this->hasOne(EconomicActivity::class, 'client_id');
    }

    public function getMiscellaneous()
    {
        return $this->hasMany(Miscellaneous::class, 'client_id');
    }

    public function getCodeAccounts()
    {
        return $this->hasMany(Account::class, 'client_id');
    }
}
