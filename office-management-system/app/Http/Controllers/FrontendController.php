<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }
}
