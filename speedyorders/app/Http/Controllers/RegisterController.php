<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {
    }

    public function index()
    {
        $activePage = 'register';

        return view('signup', compact('activePage'));
    }
}
