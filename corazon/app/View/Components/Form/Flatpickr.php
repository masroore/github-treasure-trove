<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;

class Flatpickr extends Component
{
    public $label;

    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.flatpickr');
    }
}
