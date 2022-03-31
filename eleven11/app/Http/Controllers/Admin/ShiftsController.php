<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShiftRequest;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Models\Company;
use App\Models\Location;
use App\Models\Shift;
use App\Models\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ShiftsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shift_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shifts = Shift::with(['company', 'users', 'locations'])->get();

        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        abort_if(Gate::denies('shift_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id');

        $locations = Location::all()->pluck('location_name', 'id');

        return view('admin.shifts.create', compact('companies', 'users', 'locations'));
    }

    public function store(StoreShiftRequest $request)
    {
        $shift = Shift::create($request->all());
        $shift->users()->sync($request->input('users', []));
        $shift->locations()->sync($request->input('locations', []));

        return redirect()->route('admin.shifts.index');
    }

    public function edit(Shift $shift)
    {
        abort_if(Gate::denies('shift_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id');

        $locations = Location::all()->pluck('location_name', 'id');

        $shift->load('company', 'users', 'locations');

        return view('admin.shifts.edit', compact('companies', 'users', 'locations', 'shift'));
    }

    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $shift->update($request->all());
        $shift->users()->sync($request->input('users', []));
        $shift->locations()->sync($request->input('locations', []));

        return redirect()->route('admin.shifts.index');
    }

    public function show(Shift $shift)
    {
        abort_if(Gate::denies('shift_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shift->load('company', 'users', 'locations');

        return view('admin.shifts.show', compact('shift'));
    }

    public function destroy(Shift $shift)
    {
        abort_if(Gate::denies('shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shift->delete();

        return back();
    }

    public function massDestroy(MassDestroyShiftRequest $request)
    {
        Shift::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
