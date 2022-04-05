@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.infographic.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.infographics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.infographic.fields.id') }}
                        </th>
                        <td>
                            {{ $infographic->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.infographic.fields.title') }}
                        </th>
                        <td>
                            {{ $infographic->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.infographic.fields.content') }}
                        </th>
                        <td>
                            {!! $infographic->content !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.infographics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
