<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;

    public $label;

    public $description;

    public $rows;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null, $description = null, $rows = 2)
    {
        $this->name = $name;
        $this->label = $label;
        $this->description = $description;
        $this->rows = $rows;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
