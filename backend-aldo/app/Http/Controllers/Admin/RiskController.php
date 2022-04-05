<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreRiskRequest;
use App\Http\Requests\UpdateRiskRequest;
use App\Models\Kelurahan;
use App\Models\Risk;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RiskController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('risk_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Risk::with(['kelurahan'])->select(sprintf('%s.*', (new Risk())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'risk_show';
                $editGate = 'risk_edit';
                $deleteGate = 'risk_delete';
                $crudRoutePart = 'risks';

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
            $table->editColumn('year', function ($row) {
                return $row->year ? Risk::YEAR_SELECT[$row->year] : '';
            });
            $table->addColumn('kelurahan_name', function ($row) {
                return $row->kelurahan ? $row->kelurahan->name : '';
            });

            $table->editColumn('level', function ($row) {
                return $row->level ? Risk::LEVEL_SELECT[$row->level] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'kelurahan']);

            return $table->make(true);
        }

        return view('admin.risks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('risk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.risks.create', compact('kelurahans'));
    }

    public function store(StoreRiskRequest $request)
    {
        $risk = Risk::create($request->all());

        return redirect()->route('admin.risks.index');
    }

    public function edit(Risk $risk)
    {
        abort_if(Gate::denies('risk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelurahans = Kelurahan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $risk->load('kelurahan');

        return view('admin.risks.edit', compact('kelurahans', 'risk'));
    }

    public function update(UpdateRiskRequest $request, Risk $risk)
    {
        $risk->update($request->all());

        return redirect()->route('admin.risks.index');
    }
}
