<?php

namespace Modules\Project\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Project\Services\ApiService;
use Modules\Project\Transformers\UserResource;

class ApiController extends Controller
{
    protected $request;

    protected $service;

    public function __construct(
        ApiService $service,
        Request $request
    ) {
        $this->request = $request;
        $this->service = $service;
    }

    public function setSectionOnProject(): void
    {
        $sections = $this->request->sections;
        $this->service->updateSectionOrder($sections);
    }

    public function getSectionByProject()
    {
        $project = $this->service->getProjectById($this->request->all());
        $sections = $this->service->getSectionByProjectId($this->request->all());
        $project_configuration = my_project_configuration($project);

        return $this->ok([
            'project' => $project,
            'sections' => $sections,
            'auth_user' => new UserResource(Auth::user()),
        ]);
    }

    public function getProject()
    {
        $request = $this->request->all();
        $project = $this->service->getProjectById($request);
        $project_configuration = my_project_configuration($project);

        return $this->ok([
            'project' => $project,
            'project_configuration' => $project_configuration,
        ]);
    }

    public function setTasksOnSection(): void
    {
        $request = $this->request->all();
        $this->service->updateTaskOrder($request);
    }

    public function setSubTasksOnTask(): void
    {
        $request = $this->request->all();
        $this->service->updateSubTaskOrder($request);
    }

    public function sortByField()
    {
        $request = $this->request->all();
        $sections = $this->service->sortByField($request);

        return $this->ok([
            'sections' => $sections,
        ]);
    }
}
