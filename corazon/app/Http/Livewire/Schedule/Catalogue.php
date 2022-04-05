<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Catalogue extends Component
{
    use WithPagination;

    // public $courses;

    public $day;

    public $city;

    public $school;

    public $style = '';

    public string $level = '';

    protected $listeners = [
        'cityUpdated' => 'updateCity',
        'styleUpdated' => 'updateStyle',
        'schoolUpdated' => 'updateSchool',
        'levelUpdated' => 'updateLevel',
        'focusUpdated' => 'updateFocus',
        'dayUpdated' => 'updateDay',
    ];

    public function updateCity($city): void
    {
        $this->city = $city;
        // $this->loadClasses();
    }

    public function updateStyle($style): void
    {
        $this->style = $style;
        // $this->loadClasses();
    }

    public function updateLevel($value): void
    {
        $this->level = $value;
        // $this->loadClasses();
    }

    public function updateSchool($value): void
    {
        $this->school = $value;
        // $this->loadClasses();
    }

    public function updateDay($value): void
    {
        $this->day = $value;
        // $this->loadClasses();
    }

    public function loadClasses(): void
    {

        // $this->courses       = Course::isActive()
        //                                 ->inCity($this->city)
        //                                 ->organization($this->school)
        //                                 ->style($this->style)
        //                                 ->level($this->level)
        //                                 ->dayOfWeek($this->day)
        //                                 ->inRandomOrder()
        //                                 ->paginate(10);
    }

    public function mount(): void
    {
        $this->loadClasses();
    }

    public function render()
    {
        Course::shouldExpire()->get()->each->expire();

        $fields = [
            'id', 'name', 'level', 'focus',
            'monday', 'start_time_mon', 'end_time_mon',
            'tuesday', 'start_time_tue', 'end_time_tue',
            'wednesday', 'start_time_wed', 'end_time_wed',
            'thursday', 'start_time_thu', 'end_time_thu',
            'friday', 'start_time_fri', 'end_time_fri',
            'saturday', 'start_time_sat', 'end_time_sat',
            'sunday', 'start_time_sun', 'end_time_sun',
            'full_price', 'organization_id', 'classroom_id',
        ];

        return view('livewire.schedule.catalogue', [
            'courses' => Course::select($fields)
                ->isActive()
                ->inCity($this->city)
                ->organization($this->school)
                ->style($this->style)
                ->level($this->level)
                ->dayOfWeek($this->day)
                ->inRandomOrder()
                ->paginate(20),
        ]);
    }
}
