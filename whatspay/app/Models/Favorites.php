<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'favorable_type', 'favorable_id',
    ];

    public function favorable()
    {
        return $this->morphTo();
    }
}
