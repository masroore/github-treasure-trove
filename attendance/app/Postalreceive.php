<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postalreceive extends Model
{
    protected $fillable = ['to', 'ref', 'address', 'from', 'docdate'];
}
