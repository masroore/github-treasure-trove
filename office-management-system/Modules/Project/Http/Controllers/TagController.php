<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Project\Services\TagService;

class TagController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        TagService $service,
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
    public function storeTag(Request $request)
    {
        $value = $request->value;
        $taskId = $request->task_id;
        $field_id = $request->field_id;

        return $this->ok($this->service->storeTag($value, $taskId, $field_id));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function removeTag(Request $request)
    {
        $tag_id = $request->tag_id;
        $task_id = $request->task_id;

        return $this->service->removeTag($task_id, $tag_id);
    }
}
