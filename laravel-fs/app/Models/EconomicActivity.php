<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class EconomicActivity extends Model
{
    use EncryptationId;

    protected $table = 'economic_activities';

    protected $fillable = ['id', 'economic_sector_id', 'activity_id', 'product_id', 'modality_id', 'client_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'name_economic_sector', 'name_activity', 'name_product', 'name_modality'];

    public function getEconomicSector()
    {
        return $this->belongsTo('App\Models\EconomicSector', 'economic_sector_id');
    }

    public function getNameEconomicSectorAttribute()
    {
        return $this->getEconomicSector->name_economic_sector;
    }

    public function getActivity()
    {
        return $this->belongsTo('App\Models\Activity', 'activity_id');
    }

    public function getNameActivityAttribute()
    {
        return $this->getActivity->name_activity;
    }

    public function getProduct()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function getNameProductAttribute()
    {
        return $this->getProduct->name_product;
    }

    public function getModality()
    {
        return $this->belongsTo('App\Models\Modality', 'modality_id');
    }

    public function getNameModalityAttribute()
    {
        return $this->getModality->name_modality;
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
