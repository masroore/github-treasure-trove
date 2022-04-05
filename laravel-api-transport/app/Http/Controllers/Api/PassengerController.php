<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PassengerStoreRequest;
use App\Http\Resources\PassengerResource;
use App\Models\Passenger;
use Illuminate\Http\Response;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PassengerResource::collection(Passenger::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PassengerStoreRequest $request)
    {
        $created_passenger = Passenger::create($request->validated());

        return new PassengerResource($created_passenger);
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
        return new PassengerResource(Passenger::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PassengerStoreRequest $request, $id)
    {
        $passenger = Passenger::where('deleted', '<', 1)->findOrFail($id);
        $passenger->update($request->validated());

        return new PassengerResource($passenger);
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
        Passenger::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $passenger = Passenger::findOrFail($id);
        $passenger->deleted = (int) !$passenger->deleted;
        $passenger->update();

        return $passenger;
    }
}
