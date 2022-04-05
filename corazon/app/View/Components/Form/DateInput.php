<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;

class DateInput extends Component
{
    public $label;

    public $name;

    public $description;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null, $description = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.date-input');
    }
}
