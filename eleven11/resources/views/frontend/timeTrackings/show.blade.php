@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.timeTracking.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.time-trackings.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.checkin_time') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->checkin_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.checkout_time') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->checkout_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.total_hours') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->total_hours }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.cost') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->cost }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.status') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.ip_address') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->ip_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.random_code') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->random_code->code ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.shift') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->shift->shift_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.location') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->location->location_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.timeTracking.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $timeTracking->company->company_name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.time-trackings.index') }}">
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