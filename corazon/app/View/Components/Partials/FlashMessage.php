<?php

namespace App\View\Components\Partials;

use Closure;
use Illuminate\View\Component;

class FlashMessage extends Component
{
    public $type;

    /**
     * Create a new component instance.
     */
    public function __construct($type = 'success')
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partials.flash-message');
    }
}
