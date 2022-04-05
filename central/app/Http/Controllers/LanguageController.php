<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * set locale.
     *
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
