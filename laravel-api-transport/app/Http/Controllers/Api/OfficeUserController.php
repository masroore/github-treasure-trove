<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeUserStoreRequest;
use App\Http\Resources\OfficeUserResource;
use App\Models\OfficeUser;
use Illuminate\Http\Response;

class OfficeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfficeUserResource::collection(OfficeUser::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OfficeUserStoreRequest $request)
    {
        $created_office_user = OfficeUser::create($request->validated());

        return new OfficeUserResource($created_office_user);
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
        return new OfficeUserResource(OfficeUser::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OfficeUserStoreRequest $request, $id)
    {
        $office_user = OfficeUser::where('deleted', '<', 1)->findOrFail($id);
        $office_user->update($request->validated());

        return new OfficeUserResource($office_user);
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
        OfficeUser::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $office_user = OfficeUser::findOrFail($id);
        $office_user->deleted = (int) !$office_user->deleted;
        $office_user->update();

        return $office_user;
    }
}
