<?php

namespace App\Http\Livewire\Student;

use App\Models\Course;
use Livewire\Component;

class StudentCourseView extends Component
{
    public Course $course;

    public function render()
    {
        return view('livewire.student.student-course-view', [
            'lessons' => $this->course->lessons()->orderByDesc('created_at')->get(),
        ]);
    }

    public function mount(): void
    {
        if (!auth()->user()->classes()->firstWhere('course_id', $this->course->id)) {
            abort(403);
        }
    }
}
