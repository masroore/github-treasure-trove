<?php

namespace App\Http\Controllers;

use App\Models\Ccat;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['destroy', 'update']);
    }

    public function inputPassword(Request $request)
    {
        // $ccat_id  = $request->ccat_id ;
        // if( ! $ccat_id){
        //     $ccat_id = 9 ;
        // }
        $customer_id = $request->customer_id;
        // $ccat = Ccat::find( $ccat_id );
        $customer = Customer::where('id', $customer_id)
            ->with('ccat')
            ->first();

        $ccat = $customer->ccat;
        $page = $request->page ?? 1;

        return view('inputPassword', [
            'ccat' => $ccat,
            'customer' => $customer,
            'page' => $page,
        ]);
    }

    public function index(Request $request)
    {
        $ccat_id = $request->ccat_id;
        if (!$ccat_id) {
            $ccat_id = 9;
        }

        $ccat = Ccat::find($ccat_id);
        $customers = Customer::where('ccat_id', $ccat_id)
            ->with('comments')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        // dd( $customers->toArray());
        return view('custs.index', compact('ccat', 'customers'));
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

        return view('custs.create', compact('ccat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (Auth::check() && Auth::user()->isAdmin()) {
            $this->validate($request, [
                'ccat_id' => 'required',
                'title' => 'required|string|max:50|min:3',
                'content' => 'required|string|min:10',
            ]);

            $customer = Customer::firstOrCreate(
                [
                    'ccat_id' => $request->ccat_id,
                    'name' => Auth::user()->nick,
                    'password' => $request->password,
                    'title' => $request->title,
                    'content' => $request->content,
                    'user_ip' => request()->ip(),
                ]
            );
        } else {
            $this->validate($request, [
                'ccat_id' => 'required',
                'name' => 'required|string|max:12|min:3',
                'password' => 'required|string|max:12|min:4',
                'title' => 'required|string|max:50|min:3',
                'content' => 'required|string|min:10',
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
        }

        return redirect('/customers?ccat_id=' . $request->ccat_id)->with('flash_message', '글이 추가 되었습니다. ');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Request $request)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
        } else {
            $key = 'cust-pass-' . $customer->id;
            if (session()->get($key) != 'ok') {
                return redirect()->route('inputPassword', [
                    'customer_id' => $customer->id,
                    'page' => $request->page,
                ]);
            }
        }

        $page = $request->page;

        return view('custs.show', compact('customer', 'page'));
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
        Customer::destroy($customer->id);

        return redirect('/customers?ccat_id=' . $ccat_id)->with('flash_message', '삭제되었습니다.');
    }
}
