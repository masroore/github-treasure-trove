<?php

namespace App\View\Components\Common;

use Illuminate\View\Component;

class TopTitle extends Component
{
    public $menu;

    public $mode;

    public function __construct($menu, $mode)
    {
        $this->menu = $menu;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.common.top-title');
    }
}
