@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.shift.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.shifts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $shift->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.shift_name') }}
                                    </th>
                                    <td>
                                        {{ $shift->shift_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.start_date') }}
                                    </th>
                                    <td>
                                        {{ $shift->start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.end_date') }}
                                    </th>
                                    <td>
                                        {{ $shift->end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.start_time') }}
                                    </th>
                                    <td>
                                        {{ $shift->start_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.end_time') }}
                                    </th>
                                    <td>
                                        {{ $shift->end_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.days') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $shift->days ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.frequency') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Shift::FREQUENCY_SELECT[$shift->frequency] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $shift->company->company_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.active') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $shift->active ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.user') }}
                                    </th>
                                    <td>
                                        @foreach($shift->users as $key => $user)
                                            <span class="label label-info">{{ $user->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.shift.fields.location') }}
                                    </th>
                                    <td>
                                        @foreach($shift->locations as $key => $location)
                                            <span class="label label-info">{{ $location->location_name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.shifts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection