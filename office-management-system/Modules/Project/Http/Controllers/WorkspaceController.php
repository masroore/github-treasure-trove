<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Project\Http\Requests\WorkSpaceRequest;
use Modules\Project\Services\WorkSpaceService;

class WorkspaceController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        WorkSpaceService $service,
        Request $request
    ) {
        $this->service = $service;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        abort(404);

        return view('project::workspaces.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        return view('project::workspaces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \App\Http\Controllers\Response
     */
    public function store(WorkSpaceRequest $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        $model = $this->service->store($request);

        return $this->success([
            'message' => 'Workspace Created',
            'model' => $model,
            'reload' => true,
        ]);
    }

    public function getUserSuggestion(Request $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        return $this->service->getUserSuggestion($request);
    }

    public function getUserSuggestionEmail(Request $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }
        $users = $this->service->currentWorkSpaceMembers($request);

        $res = [];
        foreach ($users as $user) {
            $res[] = ['text' => $user->email];
        }

        return $res;
    }
}
