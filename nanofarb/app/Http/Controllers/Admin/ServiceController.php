<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ServiceController extends Controller
{
    public function cache()
    {
        Artisan::call('cache:clear');

        return redirect()->back()
            ->with('success', trans('notifications.operation.success'));
    }

    public function export(Request $request, $type = null)
    {
        $a = new \App\Services\XMLExport('common.rezetka');

        return Response::make($a->render())
            ->header('Content-Type', 'text/xml');
    }
}
