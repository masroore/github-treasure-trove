<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SmtpInformation extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'host',
        'port',
        'from_email',
        'from_name',
        'username',
        'password',
        'encryption',
        'status',
        'created_at',
        'updated_at',
    ];

    public $sortable = [
        'id',
        'host',
        'port',
        'from_email',
        'username',
        'from_name',
        'password',
        'encryption',
        'status',
        'created_at',
        'updated_at',
    ];
}
