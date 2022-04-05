<?php

namespace App\Http\Livewire\Course;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
// use App\Http\Livewire\Traits\WithThumbnail;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Form extends Component
{
    // use WithThumbnail;
    use WithMedia;

    public $action = 'store';

    public $course;

    public $mediaComponentNames = ['thumbnail'];

    public $thumbnail;

    public $instructors;

    public $styles;

    protected $listeners = ['instructorsList' => 'updateInstructorsList', 'thumbnail' => 'updateThumbnail', 'selectedStyles' => 'updateStyles'];

    protected $rules = [
        'course.name' => 'required',
        'course.slug' => 'required',
        'course.tagline' => 'nullable',
        'course.excerpt' => 'nullable',
        'course.description' => 'nullable',
        'course.tagline' => 'nullable',
        'course.keywords' => 'nullable',

        'course.focus' => 'required',
        'course.level' => 'nullable',
        'course.level_code' => 'required',
        'course.level_number' => 'nullable',
        'course.level_label' => 'nullable',
        'course.city_id' => 'required',
        'course.type' => 'required',

        'course.duration' => 'nullable|date_format:H:i:s',

        'course.start_date' => 'required',
        'course.end_date' => 'required|date|after_or_equal:start_date',
        'course.monday' => 'nullable',
        'course.start_time_mon' => 'nullable|date_format:H:i:s',
        'course.end_time_mon' => 'nullable|date_format:H:i:s|after:course.start_time_mon',
        'course.tuesday' => 'nullable',
        'course.start_time_tue' => 'nullable|date_format:H:i:s',
        'course.end_time_tue' => 'nullable|date_format:H:i:s|after:course.start_time_tue',
        'course.wednesday' => 'nullable',
        'course.start_time_wed' => 'nullable|date_format:H:i:s',
        'course.end_time_wed' => 'nullable|date_format:H:i:s|after:course.start_time_wed',
        'course.thursday' => 'nullable',
        'course.start_time_thu' => 'nullable|date_format:H:i:s',
        'course.end_time_thu' => 'nullable|date_format:H:i:s|after:course.start_time_thu',
        'course.friday' => 'nullable',
        'course.start_time_fri' => 'nullable|date_format:H:i:s',
        'course.end_time_fri' => 'nullable|date_format:H:i:s|after:course.start_time_fri',
        'course.saturday' => 'nullable',
        'course.start_time_sat' => 'nullable|date_format:H:i:s',
        'course.end_time_sat' => 'nullable|date_format:H:i:s|after:course.start_time_sat',
        'course.sunday' => 'nullable',
        'course.start_time_sun' => 'nullable|date_format:H:i:s',
        'course.end_time_sun' => 'nullable|date_format:H:i:s|after:course.start_time_sun',

        'course.video1' => 'nullable',
        'course.video2' => 'nullable',
        'course.video3' => 'nullable',

        'course.full_price' => 'nullable',
        'course.reduced_price' => 'nullable',
        'course.student_price' => 'nullable',
        'course.unemployed_price' => 'nullable',
        'course.senior_price' => 'nullable',

        'course.standby' => 'nullable',

        'course.dropping' => 'nullable',
        'course.dropping_price' => 'nullable|numeric',

        'course.thumbnail' => 'nullable',

        'course.status' => 'required',

        'course.user_id' => 'nullable',
        'course.classroom_id' => 'required',

        'course.organization_id' => 'required',
    ];

    // public function updateThumbnail(array $file)
    // {
    //     $this->thumbnail = $file;
    // }

    public function updateStyles($styles): void
    {
        $this->styles = $styles;
    }

    public function updatedClassroom(int $id): void
    {
        $room = Classroom::find($id);
        $this->city = $room->location->id;
    }

    public function updatedCourseLevelCode($value): void
    {
        if ($value == 'op') {
            $this->course->level = 'open level';
        }
        if ($value == 'a1' || $value == 'a2' || $value == 'a3') {
            $this->course->level = 'beginner';
        }
        if ($value == 'b1' || $value == 'b2' || $value == 'b3') {
            $this->course->level = 'beginner';
        }
        if ($value == 'c1' || $value == 'c2' || $value == 'c3') {
            $this->course->level = 'advanced';
        }
        if ($value == 'd1') {
            $this->course->level = 'master';
        }
    }

    public function updateInstructorsList($ids): void
    {
        $this->instructors = $ids;
    }

    public function addInstructor($value): void
    {
        $instructor = User::find($value);
    }

    public function updatedCourseName(): void
    {
        $this->course->slug = Str::slug($this->course->name, '-') . '-' . \Carbon\Carbon::now()->timestamp;
    }

    public function updatedStyles($value): void
    {
        $this->styles = $value;
    }

    public function save()
    {
        // dd($this->course->start_time_mon);
        $this->validate();

        $this->course->user_id = auth()->user()->id;

        $this->course->save();

        // if ($this->thumbnail) {
        //     $this->handleThumbnailUpload($this->course, $this->thumbnail);
        // }
        $this->course->addFromMediaLibraryRequest($this->thumbnail)->toMediaCollection('courses');

        if ($this->instructors) {
            $this->course->instructors()->sync($this->instructors);
        }

        if ($this->styles) {
            $this->course->styles()->sync($this->styles);
        }

        $this->clearMedia();

        session()->flash('success', 'Course saved successfully.');

        return redirect(route('course.index'));
    }

    public function mount(?Course $course = null): void
    {
        if (!$course->exists) {
            $this->course = new Course();
            $this->course->status = '';
            $this->course->focus = '';
            $this->course->level = '';
        } else {
            $this->action = 'update';
            $this->course = $course;
        }
    }

    public function render()
    {
        return view('livewire.course.form');
    }
}
