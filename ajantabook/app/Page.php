<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'des'];

    protected $fillable = [

        'name', 'des', 'slug', 'status',

    ];
}
