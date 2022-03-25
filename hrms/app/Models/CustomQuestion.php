<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomQuestion extends Model
{
    public static $is_required = [
        'yes' => 'Yes',
        'no' => 'No',
    ];
    protected $fillable = [
        'question',
        'is_required',
        'created_by',
    ];
}
