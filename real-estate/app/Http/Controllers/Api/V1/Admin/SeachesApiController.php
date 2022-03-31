<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeachRequest;
use App\Http\Requests\UpdateSeachRequest;
use App\Http\Resources\Admin\SeachResource;
use App\Models\Seach;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SeachesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seach_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeachResource(Seach::all());
    }

    public function store(StoreSeachRequest $request)
    {
        $seach = Seach::create($request->all());

        return (new SeachResource($seach))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Seach $seach)
    {
        abort_if(Gate::denies('seach_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeachResource($seach);
    }

    public function update(UpdateSeachRequest $request, Seach $seach)
    {
        $seach->update($request->all());

        return (new SeachResource($seach))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Seach $seach)
    {
        abort_if(Gate::denies('seach_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seach->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
