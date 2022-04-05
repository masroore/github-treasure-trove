<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UpsoController extends Controller
{
    public function index()
    {
        return view('admin.upsos.index');
    }
}
