<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function nominees()
    {
        return $this->hasMany(Nominations::class, 'group_id', 'id')->where('status', 0);
    }
}
