<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Customer;

use Vanguard\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(): void
    {

    }

    public function create(): void
    {

    }

    public function customerForm()
    {
        $customers = Customer::where('companyId', Auth()->user()->companyId)->get();

        return view('invoice.partials.customerForm', compact('customers'));
    }

    public function store(Request $request): void
    {
        $customer = new Customer();

        $customer->companyId = Auth()->user()->companyId;
        $customer->firstName = $request->firstName;
        $customer->lastName = $request->lastName;
        $customer->phoneNumber = $request->phoneNumber;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();
    }

    public function show($id): void
    {

    }

    public function edit($id): void
    {

    }

    public function update(Request $request, $id): void
    {

    }

    public function destroy($id): void
    {

    }
}
