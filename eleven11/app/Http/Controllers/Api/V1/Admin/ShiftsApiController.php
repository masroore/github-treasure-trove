<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Http\Resources\Admin\ShiftResource;
use App\Models\Shift;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ShiftsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shift_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShiftResource(Shift::with(['company', 'users', 'locations'])->get());
    }

    public function store(StoreShiftRequest $request)
    {
        $shift = Shift::create($request->all());
        $shift->users()->sync($request->input('users', []));
        $shift->locations()->sync($request->input('locations', []));

        return (new ShiftResource($shift))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Shift $shift)
    {
        abort_if(Gate::denies('shift_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShiftResource($shift->load(['company', 'users', 'locations']));
    }

    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $shift->update($request->all());
        $shift->users()->sync($request->input('users', []));
        $shift->locations()->sync($request->input('locations', []));

        return (new ShiftResource($shift))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Shift $shift)
    {
        abort_if(Gate::denies('shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shift->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
