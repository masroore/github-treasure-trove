<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model
{
    use EncryptationId;

    protected $table = 'miscellaneouses';

    protected $fillable = ['id', 'name_miscelaneous', 'social_network_id', 'client_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['name_social', 'crypt_id'];

    public function getNameSocialAttribute()
    {
        return $this->getSocialNetwork->name_social;
    }

    public function getSocialNetwork()
    {
        return $this->belongsTo('App\Models\SocialNetwork', 'social_network_id');
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
