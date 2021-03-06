<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Paymentmethod;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoiceCrudController.
 *
 * @property \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    use ShowOperation { show as traitShow; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('invoice', 'invoices');
        $this->crud->addButtonFromView('top', 'createInvoice', 'createInvoice', 'start');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     */
    protected function setupListOperation(): void
    {
        if (config('invoicing.invoice_numbering') === 'manual') {
            CRUD::column('receipt_number');
        } else {
            CRUD::column('invoice_number');

            CRUD::addColumn([
                'name' => 'invoiceType', // name of relationship method in the model
                'type' => 'relationship',
                'label' => 'Type',
                'searchLogic' => false,
                'attribute' => 'name',
            ]);
        }
        CRUD::column('client_name');
        CRUD::column('client_idnumber');
        CRUD::column('client_address');
        CRUD::column('client_email');
        CRUD::column('total_price');
        CRUD::column('created_at');
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(InvoiceRequest::class);

        CRUD::field('date');

        if (config('invoicing.invoice_numbering') === 'manual') {
            CRUD::field('receipt_number');
        } else {
            CRUD::field('invoice_number');

            CRUD::addField([
                'name' => 'invoiceType', // name of relationship method in the model
                'type' => 'relationship',
                'label' => 'Type',
                'searchLogic' => false,
                'attribute' => 'name',
            ]);
        }

        CRUD::field('client_name');
        CRUD::field('client_idnumber');
        CRUD::field('client_address');
        CRUD::field('client_email');
        CRUD::field('total_price');
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id)->load('payments');

        if (!backpack_user()->can('enrollments.edit')) {
            abort(403);
        }

        return view('invoices.show', [
            'invoice' => $invoice,
            'availablePaymentMethods' => Paymentmethod::all(),
            'editable' => true,
        ]);
    }
}
