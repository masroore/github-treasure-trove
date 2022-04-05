<?php

namespace App\Http\Controllers;

use App\Models\Ccat;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['destroy', 'update', 'show']);
    }

    public function index(Request $request)
    {
        $ccat_id = $request->ccat_id;
        if (!$ccat_id) {
            $ccat_id = 9;
        }

        $ccat = Ccat::find($ccat_id);
        $customers = Customer::where('ccat_id', $ccat_id)
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        // dd( $customers->toArray());
        return view('customers.index', compact('ccat', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ccat_id = $request->ccat_id;
        $ccat = Ccat::find($ccat_id);

        return view('customers.create', compact('ccat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ccat_id' => 'required',
            'name' => 'required|string|max:12|min:2',
            'password' => 'required|string|max:12|min:5',

            'title' => 'required|string|max:50|min:2',
            'content' => 'required|string|min:2',
        ]);

        $customer = Customer::firstOrCreate(
            [
                'ccat_id' => $request->ccat_id,
                'name' => $request->name,
                'password' => $request->password,
                'title' => $request->title,
                'content' => $request->content,
                'user_ip' => request()->ip(),
            ]
        );

        return redirect('/customers?ccat_id=' . $request->ccat_id)->with('flash_message', '글이 추가 되었습니다. ');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Request $request)
    {
        // dd($customer->toArray());
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return redirect()->back()->with('error', '권한이 없습니다.');
        }

        $page = $request->page;

        return view('customers.show', compact('customer', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $ccat_id = $customer->ccat->id;
        // dd($ccat_id);

        Customer::destroy($customer->id);

        return redirect('/customers?ccat_id=' . $ccat_id)->with('flash_message', '삭제되었습니다.');
    }
}
