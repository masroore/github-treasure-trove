<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LevelRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Level;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class LevelCrudController extends CrudController
{
    use CreateOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(Level::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/level');
        CRUD::setEntityNameStrings(__('level'), __('levels'));
        CRUD::addClause('withTrashed');
        CRUD::addButtonFromView('line', 'toggle', 'toggle', 'end');
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn(['name' => 'name', 'label' => 'Name']);
        CRUD::addColumn(['name' => 'lms_id', 'label' => 'LMS code', 'type' => 'text'], );
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(StoreRequest::class);
        CRUD::addField(['name' => 'name', 'label' => 'Name', 'type' => 'text']);
        CRUD::addField(['name' => 'lms_id', 'label' => 'LMS code', 'type' => 'text'], );
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
