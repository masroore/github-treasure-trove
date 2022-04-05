<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use Livewire\Component;

class TeacherCoursesCreate extends Component
{
    public $name = '';

    public $code = '';

    public $section_code = '';

    public $course;

    public $editing = false;

    public function render()
    {
        return view('livewire.teacher.teacher-courses-create');
    }

    public function mount(): void
    {
        if (request('editing') && request('course')) {
            $course = Course::whereId(request('course'))->whereUserId(auth()->id())->firstOrFail();
            $this->editing = request('editing');
            $this->name = $course->name;
            $this->code = $course->code;
            $this->section_code = $course->section_code;
            $this->course = $course;
        }
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'section_code' => 'required',
        ]);
        if ($this->editing) {
            $this->course->update($data);
            session()->flash('flash_message', 'Course updated!');
            $this->redirect(route('teacher.course.manage', ['course' => $this->course]));
        } else {
            session()->flash('flash_message', 'Course created!');
            $course = auth()->user()?->courses()->create($data);
            $chatroom = $course->chatroom()->create([
                'name' => $course->name . '(' . $course->section_code . ')',
            ]);
            $chatroom->users()->attach(auth()->user());
            $this->redirect(route('teacher.courses'));
        }
    }
}
