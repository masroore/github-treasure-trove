<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateTaxManager extends Model
{
    public $timestamps = false;

    protected $guarded = [''];

    protected $table = 'state_tax_manager';
}
