<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransportStoreRequest;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use Illuminate\Http\Response;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransportResource::collection(Transport::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TransportStoreRequest $request)
    {
        $created_transport = Transport::create($request->validated());

        return new TransportResource($created_transport);
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
        return new TransportResource(Transport::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TransportStoreRequest $request, $id)
    {
        $transport = Transport::where('deleted', '<', 1)->findOrFail($id);
        $transport->update($request->validated());

        return new TransportResource($transport);
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
        Transport::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $transport = Transport::findOrFail($id);
        $transport->deleted = (int) !$transport->deleted;
        $transport->update();

        return $transport;
    }
}
