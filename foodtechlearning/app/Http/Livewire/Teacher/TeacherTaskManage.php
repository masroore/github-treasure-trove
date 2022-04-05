<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Task;
use Livewire\Component;

class TeacherTaskManage extends Component
{
    public Task $task;

    public function render()
    {
        return view('livewire.teacher.teacher-task-manage', [
            'submissions' => $this->task->submissions,
        ]);
    }

    public function delete_task(): void
    {
        $this->task->delete();
        session()->flash('flash_message', 'Task deleted successfully');
        $this->redirect(route('teacher.tasks.index', ['course' => $this->task->course]));
    }
}
