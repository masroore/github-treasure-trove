<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Submission extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'answers' => 'array',
        'assessment' => 'array',
    ];

    protected $dates = ['date_submitted', 'date_graded'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getReadableDateSubmittedAttribute()
    {
        return $this->date_submitted->format('M d, Y h:i a');
    }

    public function getReadableDateGradedAttribute()
    {
        return $this->date_graded?->format('M d, Y h:i a') ?? 'unchecked';
    }

    public function getScoreAttribute()
    {
        return collect($this->assessment)->sum('score');
    }
}
