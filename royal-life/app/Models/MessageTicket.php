<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTicket extends Model
{
    protected $table = 'message_ticket';

    protected $fillable = [
        'id_user', 'id_admin', 'id_ticket', 'type', 'message',
    ];

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }

    public function getAdmin()
    {
        return $this->belongsTo('App\Models\User', 'id_admin', 'id');
    }

    public function getTicket()
    {
        return $this->belongsTo('App\Models\Ticket', 'id_ticket', 'id');
    }
}
