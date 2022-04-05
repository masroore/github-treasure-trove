<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CampusRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Campus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CampusCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        CRUD::setModel(Campus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/campus');
        CRUD::setEntityNameStrings(__('campus'), __('campuses'));

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        CRUD::addColumn(['name' => 'name', 'label' => 'Name']);
        CRUD::addField(['name' => 'name', 'label' => 'Name', 'type' => 'text']);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(StoreRequest::class);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
