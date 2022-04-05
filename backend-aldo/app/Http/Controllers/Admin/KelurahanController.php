<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyKelurahanRequest;
use App\Http\Requests\StoreKelurahanRequest;
use App\Http\Requests\UpdateKelurahanRequest;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('kelurahan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Kelurahan::with(['kecamatans'])->select(sprintf('%s.*', (new Kelurahan())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'kelurahan_show';
                $editGate = 'kelurahan_edit';
                $deleteGate = 'kelurahan_delete';
                $crudRoutePart = 'kelurahans';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('kecamatans_name', function ($row) {
                return $row->kecamatans ? $row->kecamatans->name : '';
            });

            $table->editColumn('kecamatans.color', function ($row) {
                return $row->kecamatans ? (is_string($row->kecamatans) ? $row->kecamatans : $row->kecamatans->color) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'kecamatans']);

            return $table->make(true);
        }

        return view('admin.kelurahans.index');
    }

    public function create()
    {
        abort_if(Gate::denies('kelurahan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.kelurahans.create', compact('kecamatans'));
    }

    public function store(StoreKelurahanRequest $request)
    {
        $kelurahan = Kelurahan::create($request->all());

        return redirect()->route('admin.kelurahans.index');
    }

    public function edit(Kelurahan $kelurahan)
    {
        abort_if(Gate::denies('kelurahan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kelurahan->load('kecamatans');

        return view('admin.kelurahans.edit', compact('kecamatans', 'kelurahan'));
    }

    public function update(UpdateKelurahanRequest $request, Kelurahan $kelurahan)
    {
        $kelurahan->update($request->all());

        return redirect()->route('admin.kelurahans.index');
    }

    public function show(Kelurahan $kelurahan)
    {
        abort_if(Gate::denies('kelurahan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahan->load('kecamatans');

        return view('admin.kelurahans.show', compact('kelurahan'));
    }

    public function destroy(Kelurahan $kelurahan)
    {
        abort_if(Gate::denies('kelurahan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahan->delete();

        return back();
    }

    public function massDestroy(MassDestroyKelurahanRequest $request)
    {
        Kelurahan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
