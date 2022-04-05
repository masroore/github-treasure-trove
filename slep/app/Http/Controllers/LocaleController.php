<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function locale(Request $request)
    {
        //App::setLocale($locale);
        session()->put('locale', $request->input('locale'));

        return redirect()->back();
    }
}
