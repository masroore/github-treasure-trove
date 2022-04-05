<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\View\Component;

class StylesList extends Component
{
    public $list;

    /**
     * Create a new component instance.
     */
    public function __construct($list)
    {
        $this->list = $list;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.styles-list');
    }
}
