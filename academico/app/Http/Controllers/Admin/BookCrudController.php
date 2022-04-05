<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Book;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class BookCrudController extends CrudController
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
        CRUD::setModel(Book::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/book');
        CRUD::setEntityNameStrings(__('book'), __('books'));

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        CRUD::addColumns([
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'price', 'label' => 'Price'],
            ['name' => 'product_code', 'label' => 'Product Code'],
        ]);

        CRUD::addFields([
            ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['name' => 'price', 'label' => 'Price', 'type' => 'number', 'attributes' => ['step' => '0.01']],
            ['name' => 'product_code', 'label' => 'Product Code', 'type' => 'text'],
        ]);
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
