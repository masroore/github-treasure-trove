@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.density.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.densities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.id') }}
                        </th>
                        <td>
                            {{ $density->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.kelurahans') }}
                        </th>
                        <td>
                            {{ $density->kelurahans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.area') }}
                        </th>
                        <td>
                            {{ $density->area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.population') }}
                        </th>
                        <td>
                            {{ $density->population }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.density') }}
                        </th>
                        <td>
                            {{ $density->density }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.density.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Density::YEAR_SELECT[$density->year] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.densities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
