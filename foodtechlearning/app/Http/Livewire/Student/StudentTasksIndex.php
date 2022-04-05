<?php

namespace App\Http\Livewire\Student;

use App\Models\Course;
use App\Models\Task;
use Livewire\Component;

class StudentTasksIndex extends Component
{
    public Course $course;

    public ?Task $current_task;

    public function render()
    {
        return view('livewire.student.student-tasks-index', [
            'tasks' => $this->course->tasks,
            'attachments' => $this->current_task?->getMedia(),
            'submission' => $this->current_task?->user_submission,
        ]);
    }

    public function mount(): void
    {
        $this->current_task = $this->course->tasks->first();
    }

    public function preview_task(Task $task): void
    {
        $this->current_task = $task;
        $this->dispatchBrowserEvent('open-task-preview');
    }
}
