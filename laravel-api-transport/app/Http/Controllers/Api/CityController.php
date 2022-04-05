<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CityResource::collection(City::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        $created_city = City::create($request->validated());

        return new CityResource($created_city);
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
        return new CityResource(City::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CityStoreRequest $request, $id)
    {
        $city = City::where('deleted', '<', 1)->findOrFail($id);
        $city->update($request->validated());

        return new CityResource($city);
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
        City::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $city = City::findOrFail($id);
        $city->deleted = (int) !$city->deleted;
        $city->update();

        return $city;
    }
}
