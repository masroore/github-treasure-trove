<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
        'skill_rate',
    ];

    public function skillData()
    {
        return $this->belongsTo(Skills::class, 'skill_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
