<?php

namespace App\Http\Livewire\Component;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;

class InstructorsList extends Component
{
    public Course $course;

    public $instructorsIDs = [];

    public $instructors;

    protected $listeners = ['instructorAdded' => 'addInstructor'];

    public function addInstructor($id): void
    {
        $this->instructorsIDs[] = $id;
        $this->instructors = User::find($this->instructorsIDs);
        $this->emit('instructorsList', $this->instructorsIDs);
    }

    public function mount(Course $course): void
    {
        if (isset($course)) {
            $this->course = $course;
        }
    }

    public function render()
    {
        return view('livewire.component.instructors-list');
    }
}
