<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceContent;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $locale = app()->getLocale();

            $maintenance_info = MaintenanceContent::where('lang', $locale)->first();

            if (null === $maintenance_info) {
                $content = '';
            } else {
                $content = $maintenance_info->content;
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $content = '';
        }

        $data['content'] = $content;

        return view('errors.503', $data);
    }
}
