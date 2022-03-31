@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.randomCode.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.random-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.randomCode.fields.id') }}
                        </th>
                        <td>
                            {{ $randomCode->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.randomCode.fields.code') }}
                        </th>
                        <td>
                            {{ $randomCode->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.randomCode.fields.active') }}
                        </th>
                        <td>
                            {{ $randomCode->active }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.randomCode.fields.location_code') }}
                        </th>
                        <td>
                            {{ $randomCode->location_code->location_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.randomCode.fields.company') }}
                        </th>
                        <td>
                            {{ $randomCode->company->company_name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.random-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection