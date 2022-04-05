<?php

namespace App\View\Components\Location;

use App\Models\Location;
use Closure;
use Illuminate\View\Component;

class Details extends Component
{
    public Location $location;

    /**
     * Create a new component instance.
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.location.details');
    }
}
