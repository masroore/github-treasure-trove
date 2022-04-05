<?php

namespace App\View\Components\Partials;

use Closure;
use Illuminate\View\Component;

class SocialLinks extends Component
{
    public $model;

    /**
     * Create a new component instance.
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partials.social-links');
    }
}
