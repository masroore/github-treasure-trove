<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

class TeacherDashboard extends Component
{
    public $date;

    public function render()
    {
        return view('livewire.teacher.teacher-dashboard');
    }
}
