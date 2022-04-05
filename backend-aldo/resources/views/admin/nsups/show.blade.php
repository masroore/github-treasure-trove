@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.nsup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.nsups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.id') }}
                        </th>
                        <td>
                            {{ $nsup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.categories') }}
                        </th>
                        <td>
                            {{ $nsup->categories->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.kecamatans') }}
                        </th>
                        <td>
                            {{ $nsup->kecamatans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.kelurahans') }}
                        </th>
                        <td>
                            {{ $nsup->kelurahans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.years') }}
                        </th>
                        <td>
                            {{ App\Models\Nsup::YEARS_SELECT[$nsup->years] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.lat') }}
                        </th>
                        <td>
                            {{ $nsup->lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nsup.fields.lng') }}
                        </th>
                        <td>
                            {{ $nsup->lng }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.nsups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
