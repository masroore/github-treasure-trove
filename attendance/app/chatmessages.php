<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class chatmessages extends Model
{
    protected $fillable = ['from', 'to', 'is_read', 'message', 'type', 'file', 'filetype', 'code', 'semester', 'year', 'lectid', 'lecname'];
}
