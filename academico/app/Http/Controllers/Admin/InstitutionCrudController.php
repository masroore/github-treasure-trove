<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InstitutionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Class InstitutionCrudController.
 *
 * @property \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InstitutionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use CreateOperation;
    use ListOperation;
    use ShowOperation { show as traitShow; }
    use UpdateOperation;

    public function setup(): void
    {
        $this->crud->setModel('App\Models\Institution');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/institution');
        $this->crud->setEntityNameStrings('institution', 'institutions');
    }

    protected function setupListOperation(): void
    {
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => __('Name')]);
    }

    protected function setupCreateOperation(): void
    {
        $this->crud->setValidation(InstitutionRequest::class);

        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => __('Name')]);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    public function show($id)
    {
        return redirect()->route('student.index', ['institution_id' => $id]);
    }
}
