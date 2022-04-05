<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RhythmRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Rhythm;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RhythmCrudController extends CrudController
{
    use CreateOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(Rhythm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rhythm');
        CRUD::setEntityNameStrings(__('rhythm'), __('rhythms'));
        CRUD::addClause('withTrashed');
        CRUD::addButtonFromView('line', 'toggle', 'toggle', 'end');
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumns([
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'default_volume', 'label' => 'Default volume'],
            ['name' => 'product_code', 'label' => 'Product code'],
            ['name' => 'lms_id', 'label' => 'LMS code', 'type' => 'text'],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(StoreRequest::class);
        CRUD::addFields([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'default_volume', 'label' => 'Default volume', 'type' => 'text'],
            ['name' => 'product_code', 'label' => 'Product code', 'type' => 'text'],
            ['name' => 'lms_id', 'label' => 'LMS code', 'type' => 'text'],
        ]);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
