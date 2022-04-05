<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Country;
use App\Models\Storage;
use App\Models\TelephoneOperator;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            $storages = Storage::where('type_storage_id', '=', 2)->get();

            return view('agencies.index', compact('storages'));
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Request::ajax()) {
            $bank = Bank::where('status', 1)->pluck('name_bank', 'id');
            $val = 2;
            $country = Country::pluck('name_country', 'id');
            $code = TelephoneOperator::pluck('code', 'id');

            return view('agencies.create', compact('bank', 'country', 'code', 'val'));
        }

        return Redirect::to('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Request::ajax()) {
            $agency = Storage::find($id);
            $val = 2;

            return view('agencies.edit', compact('agency', 'val'));
        }

        return Redirect::to('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
