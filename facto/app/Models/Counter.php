<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $table = 'counters';

    protected $fillable = ['date', 'yy', 'mm', 'dd', 'day_of_week', 'page_view', 'unique_view'];
}
