<?php

namespace Modules\Project\Services;

use Modules\Project\Jobs\SendTeamInviteMailJob;
use Modules\Project\Repositories\SectionRepository;

class SectionService
{
    public $repo;

    public function __construct(SectionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store($params)
    {
        $members = $this->getMemberUserId(explode(',', gv($params, 'members')));
        $team = $this->repo->create($this->formatParams($params));
        $team->users()->attach($members);

        foreach ($team->users as $key => $user) {
            dispatch(new SendTeamInviteMailJob($user, $team));
        }

        return $team;
    }

    protected function formatParams($params, $model_id = null): array
    {
        return [
            'name' => gv($params, 'name', 'Untitled Section'),
            'project_id' => gv($params, 'project_id'),
            'order' => gv($params, 'order', 0),
        ];
    }

    public function update($params, $id)
    {
        $model = $this->findOrFail($id);

        return $this->repo->update($model, $this->formatParams($params, $model->id));
    }

    public function updateName($request): void
    {
        $section = $this->findOrFail(gv($request, 'section_id'));
        $params = ['name' => gv($request, 'name', 'Untitled Section')];
        $this->repo->update($section, $params);
    }

    public function findOrFail($id)
    {
        return $this->repo->findOrFail($id);
    }

    public function create($params)
    {
        $add_to = gv($params, 'add_to');

        if ($add_to) {
            $sections = $this->repo->model->where(['project_id' => gv($params, 'project_id')])->where('order', '>', $add_to)->get();
            foreach ($sections as $s) {
                $s->order = $s->order + 1;
                $s->save();
            }
            $params['order'] = $add_to + 1;
        } else {
            $params['order'] = $add_to;
            $tasks = $this->repo->getByParam(['project_id' => gv($params, 'project_id')])->count();
            $params['order'] = $tasks;
        }

        $section = $this->repo->create($this->formatParams($params));
        $section = $this->repo->findByParam(['id' => $section->id], ['tasks']);

        return $section;
    }

    public function delete($params)
    {
        $section = $this->repo->findByParam(['id' => gv($params, 'section_id')], ['tasks']);
        if (!gbv($params, 'delete_task')) {
            $untitled_section = $this->repo->findByParam(['name' => 'Untitled Section', 'order' => 0]);
            if (!$untitled_section) {
                $untitled_section = $this->create(['add_to' => -1, 'project_id' => $section->project_id]);
            }
            foreach ($section->tasks as $task) {
                $task->section_id = $untitled_section->id;
                $task->save();
            }
        }

        return $this->repo->delete($section);
    }
}
