<?php

namespace App\View\Components\Organization;

use App\Models\Organization;
use Closure;
use Illuminate\View\Component;

class DescriptionCard extends Component
{
    public Organization $organization;

    /**
     * Create a new component instance.
     */
    public function __construct(Organization $org)
    {
        $this->organization = $org;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.organization.description-card');
    }
}
