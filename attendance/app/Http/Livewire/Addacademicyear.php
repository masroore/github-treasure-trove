<?php

namespace App\Http\Livewire;

use App\Academicyear;
use Livewire\Component;

class Addacademicyear extends Component
{
    public $academics;

    public $semester;

    public $allacdemics;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'academics' => 'required|min:9',
            'semester' => 'required',
        ]);
    }

    public function submitform(): void
    {
        $this->validate([
            'academics' => 'required|min:9',
            'semester' => 'required',
        ]);

        $data = [
            'acdemicyear' => $this->academics,
            'semester' => $this->semester,
        ];

        $created = Academicyear::create($data);

        $this->emit('Added', '0');
    }

    public function mount($academic): void
    {
        $this->allacdemics = $academic;
    }

    public function render()
    {
        return view('livewire.addacademicyear');
    }
}
