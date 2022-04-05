<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class EmailLog extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'to_email',
        'auto_responder_id',
        'is_read',
        'template_name',
        'created_at',
        'updated_at',
    ];

    public $sortable = [
        'id',
        'to_email',
        'auto_responder_id',
        'is_read',
        'template_name',
        'created_at',
        'updated_at',
    ];

    public function AutoResponder()
    {
        return $this->belongsTo(AutoResponder::class);
    }
}
