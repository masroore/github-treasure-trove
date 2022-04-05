<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\View\Component;

class Toggle extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;

    public $name;

    public $checked;

    public $helptext;

    public function __construct($label, $name, $checked, $helptext = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->checked = $checked;
        $this->helptext = $helptext;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.toggle');
    }
}
