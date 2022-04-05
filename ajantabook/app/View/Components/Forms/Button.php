<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public $text;

    public $type;

    public $class;

    public $icon;

    public function __construct($text, $type, $class, $icon = null)
    {
        $this->text = $text;
        $this->type = $type;
        $this->class = $class;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.button');
    }
}
