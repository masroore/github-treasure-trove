<?php

namespace App\Http\Livewire\Catalogue;

use Livewire\Component;

class EventsFilters extends Component
{
    public $city;

    public $style;

    public $type;

    public function updatedCity($v): void
    {
        $this->city = $v;
        $this->emit('cityEventUpdated', $this->city);
    }

    public function updatedStyle($v): void
    {
        $this->style = $v;
        $this->emit('styleEventUpdated', $this->style);
    }

    public function updatedType($v): void
    {
        $this->type = $v;
        $this->emit('typeEventUpdated', $this->type);
    }

    public function render()
    {
        return view('livewire.catalogue.events-filters', [
            'cities' => \App\Models\City::has('events')->orderBy('name')->get(),
            'styles' => \App\Models\Style::has('events')->get(),
        ]);
    }
}
