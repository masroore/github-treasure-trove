<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\View\Component;
use PragmaRX\Countries\Package\Countries;

class CountrySelect extends Component
{
    public $countries;

    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->countries = (new Countries())->all()->sortBy('name')->pluck('name.common')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.country-select');
    }
}
