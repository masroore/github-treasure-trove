@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kelurahan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kelurahans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kelurahan.fields.id') }}
                        </th>
                        <td>
                            {{ $kelurahan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kelurahan.fields.name') }}
                        </th>
                        <td>
                            {{ $kelurahan->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kelurahan.fields.kecamatans') }}
                        </th>
                        <td>
                            {{ $kelurahan->kecamatans->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kelurahans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
