<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DiscountRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Discount;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class DiscountCrudController extends CrudController
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
        CRUD::setModel(Discount::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/discount');
        CRUD::setEntityNameStrings(__('discount'), __('discounts'));
    }

    protected function setupListOperation(): void
    {
        CRUD::setColumns([
            [
                'name' => 'id',
                'label' => 'ID',
            ],
            [
                // Discount name
                'label' => __('Name'), // Table column heading
                'type' => 'text',
                'name' => 'name',
            ],
            [
                // Value
                'label' => __('Discount Value'), // Table column heading
                'type' => 'decimal',
                'name' => 'value',
                'suffix' => '%',
            ],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(StoreRequest::class);
        CRUD::addFields([
            [
                // Discount name
                'label' => __('Name'), // Table column heading
                'type' => 'text',
                'name' => 'name',
            ],
            [
                // Value
                'label' => __('Discount Value (0-100%)'), // Table column heading
                'type' => 'number',
                'attributes' => ['step' => '1'],
                'name' => 'value',
            ],
        ]);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
