<?php

namespace App\Http\Livewire\Target;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Ephemerides extends Component
{
    public $target;

    public $location;

    protected $listeners = ['locationChanged' => 'locationChanged'];

    public function locationChanged(): void
    {
        $this->location = \App\Models\Location::where('id', Auth::user()->stdlocation)->first();
    }

    public function mount(): void
    {
        $this->location = \App\Models\Location::where('id', Auth::user()->stdlocation)->first();
    }

    public function render()
    {
        return view('livewire.target.ephemerides');
    }
}
