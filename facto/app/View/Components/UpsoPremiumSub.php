<?php

namespace App\View\Components;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class UpsoPremiumSub extends Component
{
    public $upso_type_id;

    public function __construct($upsotypeid)
    {
        $this->upso_type_id = $upsotypeid;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $seconds = 60 * 60 * 24;
        $banner_index = 5 + (int) $this->upso_type_id;
        $cache_key = 'banners-' . $banner_index;

        $premia_sub = Cache::remember($cache_key, $seconds, function () use ($banner_index) {
            return Banner::where('division', $banner_index)
                ->where('status', 'A')
                ->get();
        });

        return view('components.upso-premium-sub')
            ->with('premia_sub', $premia_sub);
    }
}
