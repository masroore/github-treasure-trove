<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use TechTailor\RPG\Facade\RPG;

class RandomGenerator extends Component
{
    public $rpg;

    public $size;

    public $level;

    public $dashes;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'size' => 'numeric',
        ]);
    }

    public function mount(): void
    {
        $this->size = 12;
        $this->level = 'lud';
        $this->dashes = 1;
    }

    public function generate(): void
    {
        $messages = [
            'level.required' => Lang::get('alerts.dashboard.validation.level_required'),
            'size.required' => Lang::get('alerts.dashboard.validation.size_required'),
            'size.numeric' => Lang::get('alerts.dashboard.validation.size_numeric'),
            'dashes.required' => Lang::get('alerts.dashboard.validation.dashes_required'),
        ];

        $this->validate([
            'size' => 'required|numeric',
            'level' => 'required',
            'dashes' => 'required',
        ], $messages);

        $this->rpg = RPG::Generate($this->level, $this->size, $this->dashes);
    }

    public function render()
    {
        return view('livewire.dashboard.random-generator', [
            'rpg' => $this->rpg,
        ]);
    }
}
