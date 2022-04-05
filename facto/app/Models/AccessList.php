<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessList extends Model
{
    protected $table = 'access_lists';

    protected $fillable = ['remote_ip', 'user_agent', 'count'];
}
