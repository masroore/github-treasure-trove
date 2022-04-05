<?php

namespace App\View\Components\Layout;

use App\Models\Category;
use Illuminate\View\Component;

class DashLeft extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = Category::get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout.dash-left', );
    }
}
