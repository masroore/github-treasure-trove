<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['caused_by', 'log_date', 'description', 'log_type', 'subject', 'subject_before', 'subject_after'];

    protected $table = 'log_activity';

    public $timestamps = false;
}
