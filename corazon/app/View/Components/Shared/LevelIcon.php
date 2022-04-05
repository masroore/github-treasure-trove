<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\View\Component;

class LevelIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.level-icon');
    }
}
