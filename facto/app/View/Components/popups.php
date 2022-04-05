<?php

namespace App\View\Components;

use App\Models\Banner;
use Illuminate\View\Component;

class popups extends Component
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
        $popups = Banner::where('division', 4)
            ->where('status', 'A')
            ->get();

        // dd($popups->toArray());
        return view('components.popups', [
            'popups' => $popups,
        ]);
    }
}
