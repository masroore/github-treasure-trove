<?php

namespace App\Http\Livewire;

use App\Coureregistration;
use App\Course;
use DB;
use Livewire\Component;

class Adddegreel2 extends Component
{
    public $allprogram;
    public $course;
    public $program;
    public $name;
    public $chrs;
    public $type;

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'type' => 'required',
        ]);
    }

    public function submitform()
    {
        $this->validate([
            'name' => 'required|min:8|max:255',
            'chrs' => 'required|integer',
            'type' => 'required',
        ]);

        $maxcode = DB::table('courses')->where('level', 'level 200')->max('code');
        if ($maxcode) {
            $max = substr($maxcode, 4);
            $number = $max + 1;
            $code = 'BCPC' . $number;
        } else {
            $code = 'BCPC200';
        }

        $data = [
            'title'=>$this->name,
            'code'=>$code,
            'type' => $this->type,
            'credithours' =>$this->chrs,
            'level' => 'Level 200',
            'program' => 'Degree',
        ];

        $created = Course::create($data);

        $this->emit('Added', '0');
    }

    public function render()
    {
        return view('livewire.adddegreel2');
    }

    public function deletecourse($code)
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
