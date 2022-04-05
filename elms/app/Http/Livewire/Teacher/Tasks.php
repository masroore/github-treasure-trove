<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;

    public $task_type;

    public $courses;

    public $course_id = '';

    public $sections;

    public $section_id = '';

    protected $tasks;

    public $display_grid = true;

    public $filter = 'all';

    public function render()
    {
        $this->courses = auth()->user()->teacher->courses;
        $this->sections = auth()->user()->teacher->sections;
        $this->tasks = $this->tasks = auth()->user()->teacher->tasks()->with('module')->withSectionCode()->withUngraded()->withGraded()->withSubmissions()->where('task_type_id', $this->task_type->id);
        if ($this->course_id) {
            $this->tasks = $this->tasks->whereHas('section', function ($query): void {
                $query->where('course_id', $this->course_id);
            });
            $this->sections = auth()->user()->teacher->sections->where('course_id', $this->course_id);
        }
        if ($this->section_id) {
            $this->tasks = $this->tasks->where('section_id', $this->section_id);
        }
        switch ($this->filter) {
            case 'all':
                $this->tasks = $this->tasks->get();

                break;
            case 'toGrade':
                $this->tasks = $this->tasks->get()->filter(function ($t) {
                    return $t->ungraded > 0;
                });

                break;
            case 'pastDeadline':
                $this->tasks = $this->tasks->where('deadline', '<', now())->get();

                break;
        }
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $this->tasks = new LengthAwarePaginator(
            $this->tasks->forPage($page, $perPage),
            $this->tasks->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('livewire.teacher.tasks', [
            'tasks' => $this->tasks,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function updatedCourseId(): void
    {
        $this->section_id = '';
    }

    public function deleteTask($task_id)
    {
        $task = Task::find($task_id);
        if (!$task) {
            abort(404);
        }
        if ($task->students()->count()) {
            return $this->alert('error', 'Task already has submissions.', ['toast' => false, 'position' => 'center']);
        }
        $task->calendar_event()->delete();
        $task->delete();

        return $this->alert('success', 'Task was successfully deleted.', ['toast' => false, 'position' => 'center']);
    }

    public function mount($task_type): void
    {
        $this->task_type = TaskType::find($task_type);
        $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->paginate(10);
    }

    public function displayGrid(): void
    {
        $this->display_grid = true;
        switch ($this->filter) {
            case 'all':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get();

                break;
            case 'toGrade':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get()->filter(function ($t) {
                    return $t->ungraded == 0;
                });

                break;
            case 'pastDeadline':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->where('deadline', '<', now())->get();

                break;
        }
    }

    public function displayList(): void
    {
        $this->display_grid = false;
        switch ($this->filter) {
            case 'all':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get();

                break;
            case 'toGrade':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get()->filter(function ($t) {
                    return $t->ungraded == 0;
                });

                break;
            case 'pastDeadline':
                $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->where('deadline', '<', now())->get();

                break;
        }
    }

    public function noFilter(): void
    {
        $this->resetPage();
        $this->filter = 'all';
        $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get();
    }

    public function filterToGrade(): void
    {
        $this->resetPage();
        $this->filter = 'toGrade';
        $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->get()->filter(function ($t) {
            return $t->ungraded == 0;
        });
    }

    public function filterPastDeadline(): void
    {
        $this->resetPage();
        $this->filter = 'pastDeadline';
        $this->tasks = auth()->user()->teacher->tasks()->where('task_type_id', $this->task_type->id)->where('deadline', '<', now())->get();
    }
}
