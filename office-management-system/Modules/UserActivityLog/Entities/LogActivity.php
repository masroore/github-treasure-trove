<?php

namespace Modules\UserActivityLog\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activity';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
