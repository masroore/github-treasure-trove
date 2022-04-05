<?php

namespace Modules\Project\Services;

use Carbon\Carbon;
use DB;
use Modules\Project\Repositories\FieldRepository;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Repositories\SectionRepository;
use Modules\Project\Repositories\TaskRepository;
use Modules\Project\Transformers\ProjectResource;
use Modules\Project\Transformers\SectionCollection;

class ApiService
{
    protected $task;

    protected $section;

    protected $project;

    protected $field;

    public function __construct(
        TaskRepository $task,
        SectionRepository $section,
        ProjectRepository $project,
        FieldRepository $field
    ) {
        $this->task = $task;
        $this->section = $section;
        $this->project = $project;
        $this->field = $field;
    }

    public function getTaskByProjectId($project_id)
    {
        return $this->task->getByParam(['project_id' => $project_id, 'section_id' => null, 'parent_id' => null]);
    }

    public function getSectionByProjectId($request)
    {
        $project_id = gv($request, 'project_id');
        $field_id = gv($request, 'field_id');
        $id = '';
        if ($field_id) {
            if ($field_id != 'Alphabetical') {
                $field = $this->field->model->findOrFail($field_id);
                if ($field->type == 'dropdown') {
                    $field_type = 'option_id';
                } else {
                    $field_type = $field->type;
                }
                $task_ids = DB::select("select task_id from field_task where field_id = :field_id Order by $field_type  desc", ['field_id' => $field_id]);

                $ids = [];
                $id = '';
                foreach ($task_ids as $task_id) {
                    $ids[] = $task_id->task_id;
                    $id .= $task_id->task_id . ',';
                }
                $id = rtrim($id, ',');
            }
        }

        $sections = SectionCollection::collection($this->section->getByParam(['project_id' => $project_id], ['tasks' => function ($q) use ($request, $field_id, $id) {
            $q = $q->with('tags');
            $completed = gv($request, 'completed');
            $completed_at = gv($request, 'completed_at');

            if ($completed == 2) {
                $q = $q->with(['tasks' => function ($s) {
                    return $s->where('completed', 0);
                }])->where('completed', 0);
            } elseif ($completed_at) {
                if ($completed_at == 'today') {
                    $q = $q->with(['tasks' => function ($s) {
                        return $s->whereDate('completed_at', '=', Carbon::today()->format('Y-m-d'));
                    }])->whereDate('completed_at', '=', Carbon::today()->format('Y-m-d'));
                } elseif ($completed_at == 'yesterday') {
                    $q = $q->with(['tasks' => function ($s) {
                        return $s->whereDate('completed_at', '=', Carbon::yesterday()->format('Y-m-d'));
                    }])->whereDate('completed_at', '=', Carbon::yesterday()->format('Y-m-d'));
                } elseif ($completed_at == '1week') {
                    $date = Carbon::today()->subDays(7);
                    $q = $q->with(['tasks' => function ($s) use ($date) {
                        return $s->whereDate('completed_at', '>=', $date);
                    }])->whereDate('completed_at', '>=', $date);
                } elseif ($completed_at == '2week') {
                    $date = Carbon::today()->subDays(14);
                    $q = $q->with(['tasks' => function ($s) use ($date) {
                        return $s->whereDate('completed_at', '>=', $date);
                    }])->whereDate('completed_at', '>=', $date);
                } elseif ($completed_at == '3week') {
                    $date = Carbon::today()->subDays(21);
                    $q = $q->with(['tasks' => function ($s) use ($date) {
                        return $s->whereDate('completed_at', '>=', $date);
                    }])->whereDate('completed_at', '>=', $date);
                }
            } elseif ($completed == 1) {
                $q = $q->with(['tasks' => function ($s) {
                    return $s->where('completed', 1);
                }])->where('completed', 1);
            }

            if ($field_id == 'Alphabetical') {
                $q = $q->orderBy('name', 'asc');
            } elseif ($id) {
                $q = $q->orderByRaw("FIELD(id, $id)");
            } else {
                $q = $q->orderBy('order', 'asc');
            }

            return $q;
        }]));

        return $sections;
    }

    public function getProjectById($request)
    {
        $project_id = gv($request, 'project_id');

        return new ProjectResource($this->project->getByParam(['id' => $project_id], ['fields', 'users', 'visible_fields']));
    }

    public function updateSectionOrder($sections): void
    {
        foreach ($sections as $key => $section_id) {
            $section = $this->section->find($section_id);
            $params = [
                'order' => $key,
            ];
            $this->section->update($section, $params);
        }
    }

    public function updateTaskOrder(array $request): void
    {
        foreach ($request as $key => $sections) {
            if ($sections) {
                foreach ($sections as $section_id => $tasks) {
                    if ($tasks) {
                        foreach ($tasks as $order => $task) {
                            $task_details = $this->task->find($task);
                            $params = [
                                'section_id' => $section_id,
                                'order' => $order,
                            ];
                            $this->task->update($task_details, $params);
                        }
                    }
                }
            }
        }
    }

    public function updateSubTaskOrder(array $request): void
    {
        foreach ($request['tasks'] as $order => $task) {
            $task_details = $this->task->find($task);
            $params = [
                'parent_id' => $request['task_id'],
                'order' => $order,
            ];
            $this->task->update($task_details, $params);
        }
    }

    public function sortByField(array $request)
    {
        $project_id = gv($request, 'project_id');
        $field_id = gv($request, 'field_id');

        if ($field_id == 'Alphabetical') {
            return $this->section->model->with(['tasks' => function ($q) {
            return $q->orderBy('name', 'asc');
            }])->where('project_id', $project_id)->orderBy('order', 'asc')->get();
        }

        $field = $this->field->model->findOrFail($field_id);
        if ($field->type == 'dropdown') {
            $field_type = 'option_id';
        } else {
            $field_type = $field->type;
        }
        $task_ids = DB::select("select task_id from field_task where field_id = :field_id Order by $field_type  desc", ['field_id' => $field_id]);

        $ids = [];
        $id = '';
        foreach ($task_ids as $task_id) {
            $ids[] = $task_id->task_id;
            $id .= $task_id->task_id . ',';
        }
        $id = rtrim($id, ',');

        return $this->section->model->with(['tasks' => function ($q) use ($id) {
            return $q->orderByRaw("FIELD(id, $id)");
        }])->where('project_id', $project_id)->orderBy('order', 'asc')->get();
    }
}
