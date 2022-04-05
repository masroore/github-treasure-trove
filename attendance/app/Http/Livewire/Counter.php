<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;

    public $display;

    public function render()
    {
        return view('livewire.counter');
    }

    public function increment(): void
    {
        ++$this->count;
    }

    public function decrement(): void
    {
        --$this->count;
    }
}
