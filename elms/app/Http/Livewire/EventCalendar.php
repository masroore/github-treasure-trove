<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EventCalendar extends Component
{
    public function render()
    {
        return view('livewire.event-calendar')
            ->extends('layouts.master')
            ->section('content');
    }
}
