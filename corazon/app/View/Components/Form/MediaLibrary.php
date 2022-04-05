<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;

class MediaLibrary extends Component
{
    public $name;

    public $model;

    public $collection;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $model, $collection)
    {
        $this->name = $name;
        $this->model = $model;
        $this->collection = $collection;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.media-library');
    }
}
