<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySeachRequest;
use App\Http\Requests\StoreSeachRequest;
use App\Http\Requests\UpdateSeachRequest;
use App\Models\Seach;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SeachesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seach_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seaches = Seach::all();

        return view('admin.seaches.index', compact('seaches'));
    }

    public function create()
    {
        abort_if(Gate::denies('seach_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seaches.create');
    }

    public function store(StoreSeachRequest $request)
    {
        $seach = Seach::create($request->all());

        return redirect()->route('admin.seaches.index');
    }

    public function edit(Seach $seach)
    {
        abort_if(Gate::denies('seach_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seaches.edit', compact('seach'));
    }

    public function update(UpdateSeachRequest $request, Seach $seach)
    {
        $seach->update($request->all());

        return redirect()->route('admin.seaches.index');
    }

    public function show(Seach $seach)
    {
        abort_if(Gate::denies('seach_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seaches.show', compact('seach'));
    }

    public function destroy(Seach $seach)
    {
        abort_if(Gate::denies('seach_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seach->delete();

        return back();
    }

    public function massDestroy(MassDestroySeachRequest $request)
    {
        Seach::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
