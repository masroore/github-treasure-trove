<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends Eloquent\Model
{
    use HasFactory;

    protected $fillable = ['model_name'];
}
