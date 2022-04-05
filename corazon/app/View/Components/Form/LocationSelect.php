<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;

class LocationSelect extends Component
{
    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.location-select');
    }
}
