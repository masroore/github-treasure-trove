<?php

namespace App\Http\Livewire\Student;

use App\Models\Course;
use Livewire\Component;

class StudentGradebook extends Component
{
    public $class;

    public function render()
    {
        $class = Course::find($this->class);

        return view('livewire.student.student-gradebook', [
            'classes' => auth()->user()?->classes,
            'tasks' => $class?->tasks->groupBy('task_type_id') ?? [],
            'submissions' => auth()->user()?->submissions,
        ]);
    }

    public function mount(): void
    {
        $this->class = auth()->user()?->classes()->first()?->id;
    }
}
