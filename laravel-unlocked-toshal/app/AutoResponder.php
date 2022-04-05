<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AutoResponder extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'subject',
        'template',
        'template_name',
        'status',
        'created_at',
        'updated_at',
    ];

    public $sortable = [
        'id',
        'subject',
        'template',
        'template_name',
        'status',
        'created_at',
        'updated_at',
    ];

    public function EmailLog()
    {
        return $this->hasMany(EmailLog::class);
    }
}
