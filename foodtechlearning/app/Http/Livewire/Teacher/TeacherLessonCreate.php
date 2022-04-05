<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;

class TeacherLessonCreate extends Component
{
    public Course $course;

    public Lesson $lesson;

    public $editing = false;

    public $name = '';

    public $description = '';

    public function render()
    {
        return view('livewire.teacher.teacher-lesson-create');
    }

    public function mount(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403);
        }
        if (request('editing') && request('lesson')) {
            $lesson = Lesson::whereId(request('lesson'))->whereCourseId($this->course->id)->firstOrFail();
            $this->editing = request('editing');
            $this->name = $lesson->name;
            $this->description = $lesson->description;
            $this->lesson = $lesson;
        }
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($this->editing) {
            $this->lesson->update($data);
            session()->flash('flash_message', 'Lesson updated!');
            $this->redirect(route('teacher.course.manage', ['course' => $this->course]));
        } else {
            session()->flash('flash_message', 'Lesson created!');
            $this->course->lessons()->create($data);
            $this->redirect(route('teacher.course.manage', ['course' => $this->course]));
        }
    }
}
