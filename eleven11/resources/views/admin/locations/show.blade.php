@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.location.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.id') }}
                        </th>
                        <td>
                            {{ $location->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.location_code') }}
                        </th>
                        <td>
                            {{ $location->location_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.location_name') }}
                        </th>
                        <td>
                            {{ $location->location_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.street_address') }}
                        </th>
                        <td>
                            {{ $location->street_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.city') }}
                        </th>
                        <td>
                            {{ App\Models\Location::CITY_SELECT[$location->city] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.state') }}
                        </th>
                        <td>
                            {{ App\Models\Location::STATE_SELECT[$location->state] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.country') }}
                        </th>
                        <td>
                            {{ $location->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.zip_code') }}
                        </th>
                        <td>
                            {{ $location->zip_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $location->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.latitude') }}
                        </th>
                        <td>
                            {{ $location->latitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.longitude') }}
                        </th>
                        <td>
                            {{ $location->longitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.company') }}
                        </th>
                        <td>
                            {{ $location->company->company_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.square_foot') }}
                        </th>
                        <td>
                            {{ $location->square_foot }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.annual_budget') }}
                        </th>
                        <td>
                            {{ $location->annual_budget }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.call_in_numbers') }}
                        </th>
                        <td>
                            {{ $location->call_in_numbers }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection