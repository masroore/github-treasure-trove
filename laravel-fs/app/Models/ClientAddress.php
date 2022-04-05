<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use EncryptationId;

    protected $table = 'client_addresses';

    protected $fillable = ['id', 'edf_qta_tow', 'apto_offic_loc_house', 'urbanization', 'reference_point', 'country_id', 'state_id', 'municipality_id', 'city_id', 'postal_code_id', 'client_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'name_country', 'name_state', 'name_municipality', 'name_city', 'postal_code'];

    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function getNameCountryAttribute()
    {
        return $this->getCountry->name_country;
    }

    public function getState()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function getNameStateAttribute()
    {
        return $this->getState->name_state;
    }

    public function getMunicipality()
    {
        return $this->belongsTo('App\Models\Municipality', 'municipality_id');
    }

    public function getNameMunicipalityAttribute()
    {
        return $this->getMunicipality->name_municipality;
    }

    public function getCity()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function getNameCityAttribute()
    {
        return $this->getCity->name_city;
    }

    public function getPostalCode()
    {
        return $this->belongsTo('App\Models\PostalCode', 'postal_code_id');
    }

    public function getPostalCodeAttribute()
    {
        return $this->getPostalCode->code;
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
