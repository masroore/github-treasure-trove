<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
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
        $activePage = 'login';

        return view('login', compact('activePage'));
    }
}
