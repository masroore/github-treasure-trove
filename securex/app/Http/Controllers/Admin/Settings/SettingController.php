<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin', 'password.confirm']);
    }

    /**
     * Display the app setting page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }
}
