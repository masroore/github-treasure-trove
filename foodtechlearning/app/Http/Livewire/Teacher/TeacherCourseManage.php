<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use Livewire\Component;

class TeacherCourseManage extends Component
{
    public Course $course;

    public function render()
    {
        return view('livewire.teacher.teacher-course-manage', [
            'lessons' => $this->course->lessons()->latest()->get(),
        ]);
    }

    public function mount(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function create_chatroom(): void
    {
        if ($this->course->chatroom) {
            abort(403);
        }
        $chatroom = $this->course->chatroom()->create([
            'name' => $this->course->name . '(' . $this->course->section_code . ')',
        ]);
        $chatroom->users()->attach(auth()->user());
        $this->alert('success', 'Chatroom created!');
        $this->course->refresh();
    }
}
