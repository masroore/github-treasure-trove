<?php

namespace Modules\UserActivityLog\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Routing\Controller;
use Modules\UserActivityLog\Traits\LogActivity;

class UserActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission']);
    }

    public function index()
    {
        try {
            $activities = LogActivity::logActivityLists();

            return view('useractivitylog::index', compact('activities'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function login_index()
    {
        try {
            $activities = LogActivity::logActivityListsDuty();

            return view('useractivitylog::login_index', compact('activities'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }
}
