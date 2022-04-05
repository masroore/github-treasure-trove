<?php

namespace App\View\Components\Partials;

use App\Models\Course;
use Closure;
use Illuminate\View\Component;

class DisplayDayTime extends Component
{
    public Course $course;

    /**
     * Create a new component instance.
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partials.display-day-time');
    }
}
