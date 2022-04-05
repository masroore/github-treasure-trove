<?php

namespace App\Http\Controllers;

class DeanPagesController extends Controller
{
    public function home()
    {
        session(['whereami' => 'dean']);

        return view('pages.dean.index');
    }
}
