<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;

class RelationList extends Component
{
    public function mount($model, $list): void
    {
    }

    public function render()
    {
        return view('livewire.shared.relation-list');
    }
}
