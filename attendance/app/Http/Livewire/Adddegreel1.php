<?php

namespace App\Http\Livewire;

use App\Coureregistration;
use App\Course;
use DB;
use Livewire\Component;

class Adddegreel1 extends Component
{
    public $allprogram;

    public $course;

    public $program;

    public $name;

    public $chrs;

    public $type;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'type' => 'required',
        ]);
    }

    public function submitform(): void
    {
        $this->validate([
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'type' => 'required',
        ]);

        $maxcode = DB::table('courses')->where('level', 'level 100')->max('code');
        if ($maxcode) {
            $max = substr($maxcode, 4);
            $number = $max + 1;
            $code = 'BGEC' . $number;
        } else {
            $code = 'BGEC100';
        }

        $data = [
            'title' => $this->name,
            'code' => $code,
            'type' => $this->type,
            'credithours' => $this->chrs,
            'level' => 'Level 100',
            'program' => 'Degree',
        ];

        $created = Course::create($data);

        $this->emit('Added', '0');
    }

    public function render()
    {
        return view('livewire.adddegreel1');
    }

    public function deletecourse($code): void
    {
        $course = Coureregistration::where('cource_code', $code)->first();
        if ($course) {
            $this->emit('cantdelete', '0');
        } else {
            Course::where('code', $code)->delete();

            $this->emit('deleted', '0');
        }
    }
}
