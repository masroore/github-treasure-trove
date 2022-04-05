@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sanitation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sanitations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.id') }}
                        </th>
                        <td>
                            {{ $sanitation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.kecamatan') }}
                        </th>
                        <td>
                            {{ $sanitation->kecamatan->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Sanitation::YEAR_SELECT[$sanitation->year] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.secure') }}
                        </th>
                        <td>
                            {{ $sanitation->secure }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.basic') }}
                        </th>
                        <td>
                            {{ $sanitation->basic }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sanitation.fields.poor') }}
                        </th>
                        <td>
                            {{ $sanitation->poor }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sanitations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
