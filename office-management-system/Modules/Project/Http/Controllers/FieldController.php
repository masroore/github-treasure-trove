<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Services\FieldService;

class FieldController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        FieldService $service,
        Request $request
    ) {
        $this->request = $request;
        $this->service = $service;
    }

    public function store(): void
    {
        $this->service->store($this->request->all());
    }

    public function edit()
    {
        return $this->service->findOrFail($this->request->field_id);
    }

    public function delete()
    {
        return $this->service->delete($this->request->field_id);
    }
}
