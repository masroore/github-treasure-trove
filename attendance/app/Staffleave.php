<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffleave extends Model
{
    protected $fillable = ['user_id', 'staffid', 'role', 'applydate', 'leavedate', 'leavetype', 'days', 'status', 'reason', 'note'];
}
