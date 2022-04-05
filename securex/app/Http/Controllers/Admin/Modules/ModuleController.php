<?php

namespace App\Http\Controllers\Admin\Modules;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin']);
    }

    /**
     * Show the modules page.
     */
    public function index()
    {
        return view('admin.modules.index');
    }
}
