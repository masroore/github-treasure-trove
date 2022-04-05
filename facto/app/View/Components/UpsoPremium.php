<?php

namespace App\View\Components;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class UpsoPremium extends Component
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
        $seconds = 60 * 60 * 24;
        $cache_key = 'banners-5';

        $premia = Cache::remember($cache_key, $seconds, function () {
            return Banner::where('division', 5)
                ->where('status', 'A')
                ->get();
        });

        return view('components.upso-premium')
            ->with('premia', $premia);
    }
}
