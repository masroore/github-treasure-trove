@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ipal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ipals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.id') }}
                        </th>
                        <td>
                            {{ $ipal->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.kelurahans') }}
                        </th>
                        <td>
                            {{ $ipal->kelurahans->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.categories') }}
                        </th>
                        <td>
                            {{ $ipal->categories->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.name') }}
                        </th>
                        <td>
                            {{ $ipal->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.address') }}
                        </th>
                        <td>
                            {{ $ipal->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.lat') }}
                        </th>
                        <td>
                            {{ $ipal->lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.lng') }}
                        </th>
                        <td>
                            {{ $ipal->lng }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.capacity') }}
                        </th>
                        <td>
                            {{ $ipal->capacity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\Ipal::YEAR_SELECT[$ipal->year] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.service') }}
                        </th>
                        <td>
                            @foreach($ipal->services as $key => $service)
                                <span class="label label-info">{{ $service->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ipal.fields.photos') }}
                        </th>
                        <td>
                            @foreach($ipal->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ipals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
