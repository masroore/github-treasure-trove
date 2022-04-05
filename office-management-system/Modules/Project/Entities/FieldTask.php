<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;

class FieldTask extends Pivot
{
    use LogsActivity;

    protected $fillable = [];

    public function option()
    {
        return $this->belongsTo(FieldOption::class, 'option_id');
    }

    public function assinge()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
