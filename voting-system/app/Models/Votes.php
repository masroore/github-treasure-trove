<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Votes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'artist_id',
        'group_id',
        'email',
        'stage_id',
        'season_id',
        'device',
        'ipaddress',
    ];

    public function device()
    {
        return $this->belongsTo(Devices::class);
    }
}
