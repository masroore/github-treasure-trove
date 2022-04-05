@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kecamatan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kecamatans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kecamatan.fields.id') }}
                        </th>
                        <td>
                            {{ $kecamatan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kecamatan.fields.name') }}
                        </th>
                        <td>
                            {{ $kecamatan->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kecamatan.fields.color') }}
                        </th>
                        <td>
                            {{ $kecamatan->color }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kecamatans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#kecamatan_secureds" role="tab" data-toggle="tab">
                {{ trans('cruds.secured.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="kecamatan_secureds">
            @includeIf('admin.kecamatans.relationships.kecamatanSecureds', ['secureds' => $kecamatan->kecamatanSecureds])
        </div>
    </div>
</div>

@endsection
