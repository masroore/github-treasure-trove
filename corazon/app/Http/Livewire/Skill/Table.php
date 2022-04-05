<?php

namespace App\Http\Livewire\Skill;

use App\Http\Livewire\Traits\WithSorting;
use App\Models\Skill;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    use WithSorting;

    public $search = '';

    public function render()
    {
        return view('livewire.skill.table', [
            'collection' => Skill::when($this->sortField, function ($query): void {
                $query->orderBy($this->sortField, $this->sortDirection);
            })->paginate(10),
        ]);
    }
}
