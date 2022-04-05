<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\View\Component;

class PhotoGallery extends Component
{
    public $photos;

    public $label;

    /**
     * Create a new component instance.
     */
    public function __construct($photos, $label = null)
    {
        $this->photos = $photos;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.photo-gallery');
    }
}
