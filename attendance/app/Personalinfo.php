<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personalinfo extends Model
{
    protected $fillable = [
        'surname', 'middlename', 'firstnames', 'gender',
        'dateofbirth', 'religion', 'denomination', 'placeofbirth',
        'nationality', 'hometown', 'region', 'disability', 'postcode', 'address',
        'email', 'phone', 'maritalstutus', 'profileimg', 'approve', 'approved', 'status', 'academicyear', 'year', 'title', ];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }

    public function getpersonal($id)
    {
        return Applicationinfo::where('osncode_id', $id)->first();
    }

    public function level100($id)
    {
        return Applicationinfo::where('osncode_id', $id)
            ->where('entrylevel', 'level 100')->first();
    }

    public function applicationinfo()
    {
        return $this->hasOne('App\Applicationinfo', 'osncode_id');
    }

    public function results()
    {
        return $this->hasMany('App\Result', 'osncode_id');
    }
}
