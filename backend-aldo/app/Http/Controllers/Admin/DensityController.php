<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDensityRequest;
use App\Http\Requests\StoreDensityRequest;
use App\Http\Requests\UpdateDensityRequest;
use App\Models\Density;
use App\Models\Kelurahan;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class DensityController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('density_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $densities = Density::with(['kelurahans'])->get();

        return view('admin.densities.index', compact('densities'));
    }

    public function create()
    {
        abort_if(Gate::denies('density_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.densities.create', compact('kelurahans'));
    }

    public function store(StoreDensityRequest $request)
    {
        $density = Density::create($request->all());

        return redirect()->route('admin.densities.index');
    }

    public function edit(Density $density)
    {
        abort_if(Gate::denies('density_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $density->load('kelurahans');

        return view('admin.densities.edit', compact('kelurahans', 'density'));
    }

    public function update(UpdateDensityRequest $request, Density $density)
    {
        $density->update($request->all());

        return redirect()->route('admin.densities.index');
    }

    public function show(Density $density)
    {
        abort_if(Gate::denies('density_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $density->load('kelurahans');

        return view('admin.densities.show', compact('density'));
    }

    public function destroy(Density $density)
    {
        abort_if(Gate::denies('density_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $density->delete();

        return back();
    }

    public function massDestroy(MassDestroyDensityRequest $request)
    {
        Density::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
