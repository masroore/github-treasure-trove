<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

class StudentCoursesIndex extends Component
{
    public function render()
    {
        return view('livewire.student.student-courses-index', [
            'courses' => auth()->user()?->classes,
        ]);
    }
}
