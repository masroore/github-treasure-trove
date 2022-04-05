<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\Task;
use Livewire\Component;

class TeacherTasksIndex extends Component
{
    public Course $course;

    public ?Task $current_task;

    public function render()
    {
        return view('livewire.teacher.teacher-tasks-index', [
            'tasks' => $this->course->tasks,
            'attachments' => $this->current_task?->getMedia(),
        ]);
    }

    public function mount(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403);
        }
        $this->current_task = $this->course->tasks->first();
    }

    public function preview_task(Task $task): void
    {
        $this->current_task = $task;
        $this->dispatchBrowserEvent('open-task-preview');
    }
}
