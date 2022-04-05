<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Style;
use Livewire\Component;

class Filters extends Component
{
    public $city;

    public $style;

    public $level;

    public $school;

    public $focus;

    public $day;

    public function updatedCity($v): void
    {
        $this->city = $v;
        $this->emit('cityUpdated', $this->city);
    }

    public function updatedStyle($v): void
    {
        $this->style = $v;
        $this->emit('styleUpdated', $this->style);
    }

    public function updatedLevel($v): void
    {
        $this->level = $v;
        $this->emit('levelUpdated', $this->level);
    }

    public function updatedSchool($v): void
    {
        $this->school = $v;
        $this->emit('schoolUpdated', $this->school);
    }

    public function updatedFocus($v): void
    {
        $this->focus = $v;
        $this->emit('focusUpdated', $this->focus);
    }

    public function updatedDay($v): void
    {
        $this->day = $v;
        $this->emit('dayUpdated', $this->day);
    }

    public function render()
    {
        return view('livewire.schedule.filters', [
            'cities' => \App\Models\City::has('courses')->get(),
            'styles' => Style::has('courses')->get(),
            'schools' => \App\Models\Organization::has('courses')->orderBy('name', 'asc')->get(),
        ]);
    }
}
