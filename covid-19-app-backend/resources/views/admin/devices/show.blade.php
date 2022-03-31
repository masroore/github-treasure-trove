@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.device.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.devices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.id') }}
                        </th>
                        <td>
                            {{ $device->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.udid') }}
                        </th>
                        <td>
                            {{ $device->udid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.token') }}
                        </th>
                        <td>
                            {{ $device->token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.key') }}
                        </th>
                        <td>
                            {{ $device->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.date_test') }}
                        </th>
                        <td>
                            {{ $device->date_test }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.covid') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $device->covid ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.device.fields.risk') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $device->risk ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.devices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection