<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

class TeacherCoursesIndex extends Component
{
    public function render()
    {
        return view('livewire.teacher.teacher-courses-index', [
            'courses' => auth()->user()?->courses,
        ]);
    }
}
