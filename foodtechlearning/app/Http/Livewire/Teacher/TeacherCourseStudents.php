<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;

class TeacherCourseStudents extends Component
{
    public Course $course;

    public $email = '';

    public function render()
    {
        return view('livewire.teacher.teacher-course-students', [
            'students' => $this->course->students()->orderBy('last_name')->get(),
        ]);
    }

    public function enrol()
    {
        $this->validate([
            'email' => 'required|email',
        ]);
        $student = User::firstWhere('email', $this->email);
        if ($student) {
            if ($this->course->students()->firstWhere('email', $student->email)) {
                return $this->alert('error', 'Student already enrolled!', ['toast' => false, 'position' => 'center']);
            }
            $this->course->students()->attach($student);
            $this->course->chatroom->users()->attach($student);
            $this->email = '';
            $this->alert('success', 'Student enrolled successfully!', ['toast' => false, 'position' => 'center']);
        } else {
            return $this->alert('error', 'Student does not exist!', ['toast' => false, 'position' => 'center']);
        }
    }

    public function unenroll(User $student): void
    {
        $this->course->students()->detach($student);
        $this->alert('success', 'Student unenrolled successfully!', ['toast' => false, 'position' => 'center']);
    }

    public function mount(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
