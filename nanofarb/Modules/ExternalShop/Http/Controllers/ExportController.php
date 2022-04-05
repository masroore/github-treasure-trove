<?php

namespace Modules\ExternalShop\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\ExternalShop\Export\Export;
use Response;

class ExportController extends Controller
{
    public function index(Request $request, Export $export)
    {
        Log::info(__METHOD__ . ' | Request referer:' . $request->headers->get('referer'), $request->all());

        $minutes = variable('externalshop_export_cache_minute', 0);

        return Cache::remember('externalshop-xml', $minutes, function () use ($export) {
            return Response::make($export->render())
                ->header('Content-Type', 'text/xml');
        });
    }
}
