<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimeTrackingRequest;
use App\Http\Requests\StoreTimeTrackingRequest;
use App\Http\Requests\UpdateTimeTrackingRequest;
use App\Models\Company;
use App\Models\Location;
use App\Models\RandomCode;
use App\Models\Shift;
use App\Models\TimeTracking;
use App\Models\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class TimeTrackingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('time_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeTrackings = TimeTracking::with(['user', 'random_code', 'shift', 'location', 'company'])->get();

        return view('admin.timeTrackings.index', compact('timeTrackings'));
    }

    public function create()
    {
        abort_if(Gate::denies('time_tracking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $random_codes = RandomCode::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shifts = Shift::all()->pluck('shift_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = Location::all()->pluck('location_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.timeTrackings.create', compact('users', 'random_codes', 'shifts', 'locations', 'companies'));
    }

    public function store(StoreTimeTrackingRequest $request)
    {
        $timeTracking = TimeTracking::create($request->all());

        return redirect()->route('admin.time-trackings.index');
    }

    public function edit(TimeTracking $timeTracking)
    {
        abort_if(Gate::denies('time_tracking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $random_codes = RandomCode::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shifts = Shift::all()->pluck('shift_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = Location::all()->pluck('location_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $timeTracking->load('user', 'random_code', 'shift', 'location', 'company');

        return view('admin.timeTrackings.edit', compact('users', 'random_codes', 'shifts', 'locations', 'companies', 'timeTracking'));
    }

    public function update(UpdateTimeTrackingRequest $request, TimeTracking $timeTracking)
    {
        $timeTracking->update($request->all());

        return redirect()->route('admin.time-trackings.index');
    }

    public function show(TimeTracking $timeTracking)
    {
        abort_if(Gate::denies('time_tracking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeTracking->load('user', 'random_code', 'shift', 'location', 'company');

        return view('admin.timeTrackings.show', compact('timeTracking'));
    }

    public function destroy(TimeTracking $timeTracking)
    {
        abort_if(Gate::denies('time_tracking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeTracking->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimeTrackingRequest $request)
    {
        TimeTracking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
