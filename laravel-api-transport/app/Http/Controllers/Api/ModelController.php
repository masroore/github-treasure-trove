<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelStoreRequest;
use App\Http\Resources\ModelResource;
use App\Models\Model;
use Illuminate\Http\Response;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ModelResource::collection(Model::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ModelStoreRequest $request)
    {
        $created_model = Model::create($request->validated());

        return new ModelResource($created_model);
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
        return new ModelResource(Model::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ModelStoreRequest $request, $id)
    {
        $model = Model::where('deleted', '<', 1)->findOrFail($id);
        $model->update($request->validated());

        return new ModelResource($model);
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
        Model::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $city = Model::findOrFail($id);
        $city->deleted = (int) !$city->deleted;
        $city->update();

        return $city;
    }
}
