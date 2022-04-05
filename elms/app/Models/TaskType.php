<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scopeWithTaskCount($query): void
    {
        $query->withCount(['tasks as task_count']);
    }

    public function getPluralNameAttribute()
    {
        return [
            'assignment' => 'assignments',
            'activity' => 'activities',
            'quiz' => 'quizzes',
            'exam' => 'exams',
        ][$this->name] ?? 'tasks';
    }
}
