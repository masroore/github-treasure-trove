<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDeviceRequest;
use App\Models\Device;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Device::query()->select(sprintf('%s.*', (new Device())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'device_show';
                $editGate = 'device_edit';
                $deleteGate = 'device_delete';
                $crudRoutePart = 'devices';

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
            $table->editColumn('udid', function ($row) {
                return $row->udid ? $row->udid : '';
            });
            $table->editColumn('token', function ($row) {
                return $row->token ? $row->token : '';
            });
            $table->editColumn('key', function ($row) {
                return $row->key ? $row->key : '';
            });

            $table->editColumn('covid', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->covid ? 'checked' : null) . '>';
            });
            $table->editColumn('risk', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->risk ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'covid', 'risk']);

            return $table->make(true);
        }

        return view('admin.devices.index');
    }

    public function show(Device $device)
    {
        abort_if(Gate::denies('device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.devices.show', compact('device'));
    }

    public function destroy(Device $device)
    {
        abort_if(Gate::denies('device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $device->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeviceRequest $request)
    {
        Device::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
