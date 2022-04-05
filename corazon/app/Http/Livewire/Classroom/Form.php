<?php

namespace App\Http\Livewire\Classroom;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Form extends Component
{
    use WithMedia;

    public $action = 'store';

    public Classroom $classroom;

    public $mediaComponentNames = ['photos'];

    public $photos;

    protected $rules = [
        'classroom.name' => 'required',
        'classroom.slug' => 'required',
        'classroom.m2' => 'nullable',
        'classroom.capacity' => 'nullable',
        'classroom.limit_couples' => 'nullable',
        'classroom.price_hour' => 'nullable',
        'classroom.price_month' => 'nullable',
        'classroom.currency' => 'nullable',
        'classroom.floor_type' => 'nullable',
        'classroom.mirror_type' => 'nullable',
        'classroom.has_bar' => 'nullable',
        'classroom.dance_shoes' => 'nullable',
        'classroom.description' => 'nullable',
        'classroom.color' => 'nullable',
        'classroom.location_id' => 'required',
        'classroom.user_id' => 'nullable',
    ];

    public function updatedClassroomName(): void
    {
        $this->classroom->slug = Str::slug($this->classroom->name, '-');
    }

    public function save()
    {
        $this->validate();

        $this->classroom->user_id = auth()->user()->id;

        $this->classroom->location()->associate($this->classroom->location_id)->save();

        $this->classroom->save();

        $this->classroom->addFromMediaLibraryRequest($this->photos)->toMediaCollection('classrooms');

        $this->clearMedia();

        session()->flash('success', 'Classroom saved successfully.');

        return redirect()->route('classroom.show', $this->classroom);
    }

    public function mount(?Classroom $classroom = null, $location = null): void
    {
        if ($classroom->exists) {
            $this->action = 'update';
            $this->classroom = $classroom;
        } else {
            $this->classroom = new Classroom();
            $this->classroom->color = '';
            $this->classroom->currency = '';
            $this->classroom->floor_type = '';
            $this->classroom->mirror_type = '';
            $this->classroom->location_id = $location ?? null;
        }
    }

    public function render()
    {
        return view('livewire.classroom.form');
    }
}
