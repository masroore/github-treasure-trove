<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function redirect(Request $request)
    {
        $id = $request->id;
        $url = $request->url;

        $banner = Banner::find($id);
        $banner->increment('visits');

        return redirect($url);
    }

    public function navigate(Request $request)
    {
        $url = $request->url;

        return redirect($url);
    }
}
