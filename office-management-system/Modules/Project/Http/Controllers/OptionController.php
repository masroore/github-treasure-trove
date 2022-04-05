<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Project\Services\OptionService;

class OptionController extends Controller
{
    private $request;

    private $service;

    public function __construct(Request $request, OptionService $service)
    {
        $this->service = $service;
        $this->request = $request;
    }

    public function show($id = null)
    {
        if (!$id) {
            $id = $this->request->id;
        }

        return $this->service->findOrFail($id);
    }
}
