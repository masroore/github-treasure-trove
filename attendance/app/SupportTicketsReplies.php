<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicketsReplies extends Model
{
    protected $fillable = ['tid', 'cl_id', 'admin_id', 'admin', 'name', 'date', 'message', 'image'];
}
