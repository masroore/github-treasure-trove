<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimeTrackingRequest;
use App\Http\Requests\UpdateTimeTrackingRequest;
use App\Http\Resources\Admin\TimeTrackingResource;
use App\Models\TimeTracking;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class TimeTrackingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('time_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeTrackingResource(TimeTracking::with(['user', 'random_code', 'shift', 'location', 'company'])->get());
    }

    public function store(StoreTimeTrackingRequest $request)
    {
        $timeTracking = TimeTracking::create($request->all());

        return (new TimeTrackingResource($timeTracking))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TimeTracking $timeTracking)
    {
        abort_if(Gate::denies('time_tracking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TimeTrackingResource($timeTracking->load(['user', 'random_code', 'shift', 'location', 'company']));
    }

    public function update(UpdateTimeTrackingRequest $request, TimeTracking $timeTracking)
    {
        $timeTracking->update($request->all());

        return (new TimeTrackingResource($timeTracking))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TimeTracking $timeTracking)
    {
        abort_if(Gate::denies('time_tracking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeTracking->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
