<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Location::all();

        return view('location.index', compact('locations'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('location.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $location = Location::create($request->validated());

        $request->session()->flash('location.id', $location->id);

        return redirect()->route('location.index');
    }

    /**
     * @param \App\Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Location $location)
    {
        return view('location.show', compact('location'))->with('photos', $location->getMedia('location-photos'));
    }

    /**
     * @param \App\Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Location $location)
    {
        return view('location.edit', compact('location'));
    }

    /**
     * @param \App\Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, Location $location)
    {
        $location->update($request->validated());

        $request->session()->flash('location.id', $location->id);

        return redirect()->route('location.index');
    }

    /**
     * @param \App\Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Location $location)
    {
        $location->delete();

        return redirect()->route('location.index');
    }
}
