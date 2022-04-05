<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

class TeacherDeletedCourses extends Component
{
    public function render()
    {
        return view('livewire.teacher.teacher-deleted-courses', [
            'courses' => auth()->user()?->courses()->onlyTrashed()->get(),
        ]);
    }
}
