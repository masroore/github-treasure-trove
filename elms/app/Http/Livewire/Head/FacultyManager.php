<?php

namespace App\Http\Livewire\Head;

use App\Models\Department;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class FacultyManager extends Component
{
    use WithPagination;

    protected $teachers;

    protected $users;

    public $email = '';

    public $department_id;

    public $showQuery = false;

    public function mount(): void
    {
        $this->department_id = auth()->user()->program_head->departments->first()->id;
    }

    public function render()
    {
        $department = Department::find($this->department_id);
        $this->teachers = $department ? $department->teachers()->addSelect([
            'name' => User::select('name')->whereColumn('id', 'user_id')->limit(1),
        ])->orderBy('name')->paginate(10) : collect([]);
        if ($this->email) {
            $this->showQuery = true;
            $this->users = User::where('name', 'like', "%$this->email%")->whereHas('roles', function (Builder $query): void {
                $query->where('role_id', 3);
            })->orWhere('email', 'like', "%$this->email%")->whereHas('roles', function (Builder $query): void {
                $query->where('role_id', 3);
            })->get();
        } else {
            $this->showQuery = false;
            $this->users = [];
        }

        return view('livewire.head.faculty-manager', [
            'teachers' => $this->teachers,
            'users' => $this->users,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function setEmail($email): void
    {
        $this->email = $email;
        $this->addFaculty();
    }

    public function addFaculty()
    {
        $this->validate([
            'email' => 'required|email',
            'department_id' => 'required',
        ]);
        $u = User::where('email', $this->email)->first();
        if (!$u) {
            return session()->flash('error', 'Faculty member not found.');
        }
        $u->teacher->update([
            'department_id' => $this->department_id,
            'college_id' => auth()->user()->program_head->college_id,
        ]);
        $this->email = '';
        session()->flash('message', 'Faculty member was successfully added.');
    }

    public function removeFaculty(Teacher $teacher): void
    {
        $teacher->update(['department_id' => null]);
        session()->flash('message', 'Faculty member removed.');
    }
}
