<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Osncode extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'othernames',
        'email', 'phone', 'programme', 'amount', 'status', 'year', ];

    public function personinfos()
    {
        return $this->hasMany('App\Personalinfo');
    }

    public function saveresults()
    {
        return $this->hasMany('App\Result');
    }

    public function schools()
    {
        return $this->hasMany('App\School');
    }

    public function appinfomations()
    {
        return $this->hasMany('App\Applicationinfo');
    }

    public function gurdianinfos()
    {
        return $this->hasMany('App\Guardianinfo');
    }

    public function supportdocs()
    {
        return $this->hasMany('App\Supportingdoc');
    }
}
