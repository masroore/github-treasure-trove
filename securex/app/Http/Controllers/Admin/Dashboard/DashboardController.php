<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Announcement;
use App\Models\Users\User;
use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;

class DashboardController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin']);
    }

    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $registered_today = User::whereDate('created_at', '=', date('Y-m-d'))->count();
        $total_users = User::count();
        $total_vaults = Vault::count();
        $total_sites = Site::count();

        $announcements = Announcement::all();

        return view(
            'admin.dashboard.index',
            compact(
                'announcements',
                'registered_today',
                'total_users',
                'total_vaults',
                'total_sites'
            )
        );
    }
}
