<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreSanitationRequest;
use App\Http\Requests\UpdateSanitationRequest;
use App\Models\Kecamatan;
use App\Models\Sanitation;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SanitationController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('sanitation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sanitations = Sanitation::with(['kecamatan'])->get();

        return view('admin.sanitations.index', compact('sanitations'));
    }

    public function create()
    {
        abort_if(Gate::denies('sanitation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sanitations.create', compact('kecamatans'));
    }

    public function store(StoreSanitationRequest $request)
    {
        $sanitation = Sanitation::create($request->all());

        return redirect()->route('admin.sanitations.index');
    }

    public function edit(Sanitation $sanitation)
    {
        abort_if(Gate::denies('sanitation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sanitation->load('kecamatan');

        return view('admin.sanitations.edit', compact('kecamatans', 'sanitation'));
    }

    public function update(UpdateSanitationRequest $request, Sanitation $sanitation)
    {
        $sanitation->update($request->all());

        return redirect()->route('admin.sanitations.index');
    }

    public function show(Sanitation $sanitation)
    {
        abort_if(Gate::denies('sanitation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sanitation->load('kecamatan');

        return view('admin.sanitations.show', compact('sanitation'));
    }
}
