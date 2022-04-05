<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyNsupRequest;
use App\Http\Requests\StoreNsupRequest;
use App\Http\Requests\UpdateNsupRequest;
use App\Models\Category;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Nsup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NsupController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('nsup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Nsup::with(['categories', 'kecamatans', 'kelurahans'])->select(sprintf('%s.*', (new Nsup())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'nsup_show';
                $editGate = 'nsup_edit';
                $deleteGate = 'nsup_delete';
                $crudRoutePart = 'nsups';

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
            $table->addColumn('categories_type', function ($row) {
                return $row->categories ? $row->categories->type : '';
            });

            $table->addColumn('kecamatans_name', function ($row) {
                return $row->kecamatans ? $row->kecamatans->name : '';
            });

            $table->addColumn('kelurahans_name', function ($row) {
                return $row->kelurahans ? $row->kelurahans->name : '';
            });

            $table->editColumn('years', function ($row) {
                return $row->years ? Nsup::YEARS_SELECT[$row->years] : '';
            });
            $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : '';
            });
            $table->editColumn('lng', function ($row) {
                return $row->lng ? $row->lng : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'categories', 'kecamatans', 'kelurahans']);

            return $table->make(true);
        }

        $categories = Category::get();
        $kecamatans = Kecamatan::get();
        $kelurahans = Kelurahan::get();

        return view('admin.nsups.index', compact('categories', 'kecamatans', 'kelurahans'));
    }

    public function create()
    {
        abort_if(Gate::denies('nsup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.nsups.create', compact('categories', 'kecamatans', 'kelurahans'));
    }

    public function store(StoreNsupRequest $request)
    {
        $nsup = Nsup::create($request->all());

        return redirect()->route('admin.nsups.index');
    }

    public function edit(Nsup $nsup)
    {
        abort_if(Gate::denies('nsup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $nsup->load('categories', 'kecamatans', 'kelurahans');

        return view('admin.nsups.edit', compact('categories', 'kecamatans', 'kelurahans', 'nsup'));
    }

    public function update(UpdateNsupRequest $request, Nsup $nsup)
    {
        $nsup->update($request->all());

        return redirect()->route('admin.nsups.index');
    }

    public function show(Nsup $nsup)
    {
        abort_if(Gate::denies('nsup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nsup->load('categories', 'kecamatans', 'kelurahans');

        return view('admin.nsups.show', compact('nsup'));
    }

    public function destroy(Nsup $nsup)
    {
        abort_if(Gate::denies('nsup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nsup->delete();

        return back();
    }

    public function massDestroy(MassDestroyNsupRequest $request)
    {
        Nsup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
