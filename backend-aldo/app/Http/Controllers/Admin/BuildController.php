<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBuildRequest;
use App\Http\Requests\StoreBuildRequest;
use App\Http\Requests\UpdateBuildRequest;
use App\Models\Build;
use App\Models\Category;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BuildController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('build_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Build::with(['kecamatans', 'kelurahans', 'categories'])->select(sprintf('%s.*', (new Build())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'build_show';
                $editGate = 'build_edit';
                $deleteGate = 'build_delete';
                $crudRoutePart = 'builds';

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
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->addColumn('kecamatans_name', function ($row) {
                return $row->kecamatans ? $row->kecamatans->name : '';
            });

            $table->addColumn('kelurahans_name', function ($row) {
                return $row->kelurahans ? $row->kelurahans->name : '';
            });

            $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : '';
            });
            $table->editColumn('lng', function ($row) {
                return $row->lng ? $row->lng : '';
            });
            $table->editColumn('year', function ($row) {
                return $row->year ? Build::YEAR_SELECT[$row->year] : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Build::STATUS_RADIO[$row->status] : '';
            });
            $table->editColumn('funded', function ($row) {
                return $row->funded ? Build::FUNDED_SELECT[$row->funded] : '';
            });
            $table->addColumn('categories_type', function ($row) {
                return $row->categories ? $row->categories->type : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'kecamatans', 'kelurahans', 'categories']);

            return $table->make(true);
        }

        $kecamatans = Kecamatan::get();
        $kelurahans = Kelurahan::get();
        $categories = Category::get();

        return view('admin.builds.index', compact('kecamatans', 'kelurahans', 'categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('build_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.builds.create', compact('kecamatans', 'kelurahans', 'categories'));
    }

    public function store(StoreBuildRequest $request)
    {
        $build = Build::create($request->all());

        return redirect()->route('admin.builds.index');
    }

    public function edit(Build $build)
    {
        abort_if(Gate::denies('build_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kecamatans = Kecamatan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $build->load('kecamatans', 'kelurahans', 'categories');

        return view('admin.builds.edit', compact('kecamatans', 'kelurahans', 'categories', 'build'));
    }

    public function update(UpdateBuildRequest $request, Build $build)
    {
        $build->update($request->all());

        return redirect()->route('admin.builds.index');
    }

    public function show(Build $build)
    {
        abort_if(Gate::denies('build_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $build->load('kecamatans', 'kelurahans', 'categories');

        return view('admin.builds.show', compact('build'));
    }

    public function destroy(Build $build)
    {
        abort_if(Gate::denies('build_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $build->delete();

        return back();
    }

    public function massDestroy(MassDestroyBuildRequest $request)
    {
        Build::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
