<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // $popups = Banner::where('division', 4)
        //             ->where('status', 'A')
        //             ->get();

        $seconds = 60 * 60 * 48;
        $cache_key = 'banners-4';
        $popups = Cache::remember($cache_key, $seconds, function () {
            return Banner::where('division', 4)
                ->where('status', 'A')
                ->get();
        });

        return view('main')
            ->with('popups', $popups);
    }
}
