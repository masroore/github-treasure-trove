<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deadline'];

    protected $casts = [
        'questions' => 'array',
    ];

    public function task_type()
    {
        return $this->belongsTo(TaskType::class);
    }

    public function getReadableDateCreatedAttribute()
    {
        return $this->created_at->format('M d, Y h:i a');
    }

    public function getReadableDeadlineAttribute()
    {
        return $this->deadline?->format('M d, Y h:i a') ?? 'No Deadline';
    }

    public function getMaxScoreAttribute()
    {
        return collect($this->questions)->sum('points');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user_submission()
    {
        return $this->hasOne(Submission::class)->ofMany([
            'user_id' => 'min',
        ], function ($query): void {
            $query->whereUserId(auth()->id());
        });
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
