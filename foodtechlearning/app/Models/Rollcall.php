<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rollcall extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_taken' => 'immutable_date',
    ];

    const PRESENT = 1;
    const ABSENT = 2;
    const EXCUSED = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
