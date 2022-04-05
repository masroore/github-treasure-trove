<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Package;
use Vanguard\Services;

class HomeController extends Controller
{
    public function index()
    {
        $domain = request()->getHost();

        if ($domain == 'xtremereflection.app') {
            $packages = Package::with('items', 'items.desc', 'items.desc.type')
                ->where('mainPage', 1)
                ->where('companyId', 0)
                ->where('status', 1)->get();

            $services = Services::get();

            return view('home.index', compact('packages'));
        }

        return view('home.detailDex');
    }
}
