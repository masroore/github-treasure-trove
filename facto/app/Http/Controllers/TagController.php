<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($tag, Request $request): void
    {
        dd($tag);
    }
}
