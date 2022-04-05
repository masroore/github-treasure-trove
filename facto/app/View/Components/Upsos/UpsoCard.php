<?php

namespace App\View\Components\Upsos;

use Illuminate\View\Component;

class UpsoCard extends Component
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
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.upsos.upso-card');
    }
}
