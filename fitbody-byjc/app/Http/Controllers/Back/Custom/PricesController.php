<?php

namespace App\Http\Controllers\Back\Custom;

use App\Http\Controllers\Controller;
use App\Models\Back\Custom\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = Price::orderBy('created_at', 'desc')->paginate(config('settings.pagination.admin', 20));

        return view('back.marketing.prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.marketing.prices.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Price();
        $stored = $page->validateRequest($request)->storePrice();

        if ($stored) {
            return redirect()->back()->with(['success' => 'Page was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error creating the page.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        return view('back.marketing.prices.edit', compact('price'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = new Price();
        $updated = $page->validateRequest($request)->updatePrice($id);

        if ($updated) {
            return redirect()->route('prices')->with(['success' => 'Page was succesfully updated!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error updating the page.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            return response()->json(
                Price::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
