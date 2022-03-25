<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['did', 'cl_id', 'admin_id', 'indexnumber', 'name', 'email', 'date', 'subject', 'message', 'status', 'admin', 'replyby', 'closed_by'];

    public function supportuser()
    {
        return $this->hasOne('App\User', 'id', 'cl_id');
    }
}
