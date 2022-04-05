@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.risk.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.risks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.risk.fields.id') }}
                        </th>
                        <td>
                            {{ $risk->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.risk.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Risk::YEAR_SELECT[$risk->year] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.risk.fields.kelurahan') }}
                        </th>
                        <td>
                            {{ $risk->kelurahan->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.risk.fields.level') }}
                        </th>
                        <td>
                            {{ App\Models\Risk::LEVEL_SELECT[$risk->level] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.risks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
