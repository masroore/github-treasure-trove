<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VideocallIndex extends Component
{
    public $room;

    public function render()
    {
        return view('livewire.videocall-index');
    }

    public function mount($room): void
    {
        $this->room = $room;
    }
}
