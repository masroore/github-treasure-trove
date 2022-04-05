<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use Livewire\Component;

class TeacherGradebook extends Component
{
    public $course;

    public function render()
    {
        $course = Course::find($this->course);

        return view('livewire.teacher.teacher-gradebook', [
            'courses' => auth()->user()?->courses,
            'students' => $course?->students()->orderBy('last_name')->with('submissions')->get() ?? [],
            'tasks' => $course?->tasks->groupBy('task_type_id') ?? [],
        ]);
    }

    public function mount(): void
    {
        if (request('course')) {
            $course = Course::find(request('course'));
            if ($course->user_id !== auth()->id()) {
                abort(403);
            }
            $this->course = $course->id;
        } else {
            $this->course = auth()->user()?->courses()->first()?->id;
        }
    }

    public function getbg($task_type)
    {
        return [
            'bg-gray-50',
            'bg-green-200',
            'bg-red-200',
            'bg-yellow-200',
            'bg-blue-200',
        ][$task_type];
    }
}
