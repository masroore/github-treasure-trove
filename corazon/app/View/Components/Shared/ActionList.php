<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\View\Component;

class ActionList extends Component
{
    public $route;

    public $item;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $item)
    {
        $this->route = $route;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.action-list');
    }
}
