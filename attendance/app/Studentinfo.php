<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentinfo extends Model
{
    protected $guarded = [];

    // protected $fillable = [
    // 	'fullname','gender','dateofbirth','religion','denomination','placeofbirth','nationality','hometown','region','disability','postcode','address','email','phone','maritalstutus','entrylevel','session','programme','progcode','currentlevel','indexnumber','gurdianname','relationship','occupation','mobile','employed','status','admitted','academic_year','completion','type','duration','completstatus','title'
    // ];

    public function user()
    {
        return $this->belongsto('App\User');
    }

    public function rasticate()
    {
        return $this->hasMany('App\Rasticate', 'studentid', 'indexnumber');
    }

    public function defer()
    {
        return $this->hasMany('App\Defer', 'studentid', 'indexnumber');
    }

    public function dismssal()
    {
        return $this->hasMany('App\Dismssal', 'studendid', 'indexnumber');
    }
}
