<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Amenity extends Model
{
    use Sortable;

    protected $fillable = [
        'name',
        'status',
        'created_at',
        'updated_at',
    ];
}
