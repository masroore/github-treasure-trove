<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Select2 extends Component
{
    public $name;

    public $model;

    public $collection;

    public $selected = [];

    public function updatedSelected($value): void
    {
        $this->emit('setSelectedStyles', $this->selected);
    }

    public function mount($model, $select = 'styles'): void
    {
        $this->model = $model;
        $this->name = $select;
        $this->collection = \App\Models\Style::all();
    }

    public function render()
    {
        return view('livewire.component.select2');
    }
}
