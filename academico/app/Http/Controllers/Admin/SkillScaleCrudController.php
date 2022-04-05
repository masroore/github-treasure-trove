<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SkillScaleRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Skills\SkillScale;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SkillScaleCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(SkillScale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/skillscale');
        CRUD::setEntityNameStrings(__('skill scale'), __('skill scales'));
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumns([
            ['name' => 'shortname', 'label' => 'Shortname'],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'value', 'label' => 'Value'],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(StoreRequest::class);
        CRUD::addFields([
            ['name' => 'shortname', 'label' => 'Shortname', 'type' => 'text'],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'value', 'label' => 'Value', 'type' => 'text'],
        ]);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
