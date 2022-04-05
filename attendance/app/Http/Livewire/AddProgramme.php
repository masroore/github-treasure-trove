<?php

namespace App\Http\Livewire;

use App\Programme;
use Livewire\Component;

class AddProgramme extends Component
{
    public $name;

    public $typeofp;

    public $duration;

    public $department;

    public $allprogram;

    public $code;

    // public function updated($field){

    //       $this->validateOnly($field,[
    //           'name' => 'required|min:12|max:255',
    //           'typeofp' => 'required',
    //           'code'=> 'required|min:3|max:4|unique:programmes',
    //           'duration' => 'required|integer',
    //           'department' => 'required|min:12|max:255',
    //       ]);

    //   }

    public function submitform(): void
    {
        $this->validate([
            'name' => 'required|min:12|max:255',
            'typeofp' => 'required',
            'code' => 'required|min:3|max:4|unique:programmes',
            'duration' => 'required|integer',
            'department' => 'required|min:12|max:255',
        ]);

        $data = [
            'name' => $this->name,
            'type' => $this->typeofp,
            'code' => $this->code,
            'duration' => $this->duration,
            'department' => $this->department,
        ];

        $created = Programme::create($data);

        $this->emit('Added', '0');
    }

    public function mount($program): void
    {
        $this->allprogram = $program;
    }

    public function render()
    {
        return view('livewire.add-programme');
    }
}
