<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table = 'access_logs';

    protected $fillable = ['yy', 'mm', 'dd', 'date', 'remote_ip', 'user_agent'];
}
