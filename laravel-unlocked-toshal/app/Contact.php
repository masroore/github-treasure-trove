<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Contact extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'status',
        'created_at',
        'updated_at',
    ];
}
