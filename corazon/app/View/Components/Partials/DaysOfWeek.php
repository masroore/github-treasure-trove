<?php

namespace App\View\Components\Partials;

use Closure;
use Illuminate\View\Component;

class DaysOfWeek extends Component
{
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partials.days-of-week');
    }
}
