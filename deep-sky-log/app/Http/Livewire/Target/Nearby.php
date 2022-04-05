<?php

namespace App\Http\Livewire\Target;

use Livewire\Component;

class Nearby extends Component
{
    public $target;

    public int $zoomDiameter;

    public int $zoom;

    public function mount(): void
    {
        $this->zoom = 30;
        $this->zoomDiameter = 30;
    }

    public function updated($propertyName): void
    {
        if ($propertyName == 'zoom') {
            $this->zoomDiameter = $this->zoom;
            $this->emit('zoomUpdated', $this->zoom);
            $this->emit('refreshLivewireDatatable');
        }
    }

    public function render()
    {
        return view('livewire.target.nearby');
    }
}
