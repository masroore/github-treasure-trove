@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.build.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.builds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.id') }}
                        </th>
                        <td>
                            {{ $build->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.categories') }}
                        </th>
                        <td>
                            {{ $build->categories->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.address') }}
                        </th>
                        <td>
                            {{ $build->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.kecamatans') }}
                        </th>
                        <td>
                            {{ $build->kecamatans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.kelurahans') }}
                        </th>
                        <td>
                            {{ $build->kelurahans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.lat') }}
                        </th>
                        <td>
                            {{ $build->lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.lng') }}
                        </th>
                        <td>
                            {{ $build->lng }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Build::YEAR_SELECT[$build->year] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Build::STATUS_RADIO[$build->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.build.fields.funded') }}
                        </th>
                        <td>
                            {{ App\Models\Build::FUNDED_SELECT[$build->funded] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.builds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
