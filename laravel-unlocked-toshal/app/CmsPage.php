<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CmsPage extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'slug',
        'meta_title',
        'meta_keyword',
        'meta_content',
        'status',
    ];

    public $sortable = [
        'name',
        'short_description',
        'description',
        'slug',
        'meta_title',
        'meta_keyword',
        'meta_content',
        'status',
    ];
}
