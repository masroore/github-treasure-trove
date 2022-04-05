<?php

namespace Modules\Project\Services;

use Auth;
use Modules\Project\Repositories\FieldOptionRepository;
use Modules\Project\Repositories\FieldRepository;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Repositories\TaskRepository;

class FieldService
{
    public $repo;

    public $option;

    public $project;

    public $task;

    public function __construct(
        FieldRepository $repo,
        FieldOptionRepository $option,
        ProjectRepository $project,
        TaskRepository $task
    ) {
        $this->repo = $repo;
        $this->option = $option;
        $this->project = $project;
        $this->task = $task;
    }

    public function store($data)
    {
        $model_id = gv($data, 'id');

        $option_ids = [];
        if ($model_id) {
            $model = $this->repo->find($model_id);
            $option_ids = $model->options()->pluck('id')->toArray();
            $this->repo->update($model, $this->formatParams($data, $model_id));
        } else {
            $model = $this->repo->store($this->formatParams($data));
            $project_id = gv($data, 'project_id');

            $project = $this->project->find($project_id);
            $order = $project->fields()->count();
            $project->fields()->attach($model->id, ['order' => $order]);

            $tasks = $this->task->getByParam(['project_id' => $project_id], ['fields']);
            foreach ($tasks as $task) {
                $task->fields()->attach($model->id);
            }
        }

        if ($model->type == 'dropdown') {
            $options = gv($data, 'options');
            foreach ($options as $option) {
                $option_formatted = [
                    'field_id' => $model->id,
                    'color' => gv($option, 'color'),
                    'option' => gv($option, 'option'),
                ];
                $option_id = gv($option, 'id');
                if ($option_id) {
                    $key = array_search($option_id, $option_ids);
                    if (false !== $key) {
                        unset($option_ids[$key]);
                    }
                    $option = $this->option->find($option_id);
                    $option = $this->option->update($option, $option_formatted);
                } else {
                    $this->option->store($option_formatted);
                }
            }

            $this->option->model->whereIn('id', $option_ids)->delete();
        }

        return $model;
    }

    protected function formatParams($params, $model_id = null): array
    {
        $formatted = [];
        $formatted['name'] = gv($params, 'name');
        $formatted['type'] = gv($params, 'type');

        if ($formatted['type'] == 'number') {
            $formatted['format'] = gv($params, 'format');
            if ($formatted['format'] != 'unformat') {
                $formatted['decimal'] = gv($params, 'decimals');
                if ($formatted['format'] == 'custom') {
                    $formatted['label'] = gv($params, 'label');
                    $formatted['position'] = gv($params, 'position');
                }
            }
        }

        if ($formatted['type'] == 'dropdown') {
            $formatted['notify'] = gbv($params, 'notify');
        }

        $formatted['editable'] = gbv($params, 'editable');

        if (gbv($params, 'library')) {
            $formatted['workspace_id'] = Auth::user()->current_workspace_id;
        }

        return $formatted;
    }

    public function findByUuid($uuid)
    {
        return $this->repo->findByUuid($uuid, $with = ['fields', 'users']);
    }

    public function setFieldVisibility(array $request): void
    {
        $project_id = gv($request, 'project_id');
        $field_id = gv($request, 'field_id');
        $project = $this->repo->getByParam(['id' => $project_id], ['fields']);
        foreach ($project->fields as $field) {
            if ($field->id == $field_id) {
                $field->pivot->visibility = !$field->pivot->visibility;
                $field->pivot->save();
            }
        }
    }

    public function findOrFail($field_id)
    {
        return $this->repo->findOrFail($field_id, ['options']);
    }

    public function delete($field_id)
    {
        $field = $this->repo->findOrFail($field_id);

        return $this->repo->delete($field);
    }
}
