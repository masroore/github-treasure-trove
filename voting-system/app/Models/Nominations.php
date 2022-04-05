<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nominations extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function artist()
    {
        return $this->belongsTo(Artists::class, 'artist_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id', 'id');
    }
}
