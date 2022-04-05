<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body', 'user'];
}
