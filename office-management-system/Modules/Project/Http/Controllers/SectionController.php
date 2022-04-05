<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Services\SectionService;

class SectionController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        SectionService $service,
        Request $request
    ) {
        $this->service = $service;
        $this->request = $request;
    }

    public function store()
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        return $this->service->create($this->request->all());
    }

    public function updateName(): void
    {
        $request = $this->request->all();
        $this->service->updateName($request);
    }

    public function delete()
    {
        $this->service->delete($this->request->all());

        return $this->success(['message' => __('project::section.deleted_successfully')]);
    }
}
