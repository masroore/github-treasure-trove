@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.company.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.companies.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $company->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.logo') }}
                                    </th>
                                    <td>
                                        @if($company->logo)
                                            <a href="{{ $company->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $company->logo->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.company_name') }}
                                    </th>
                                    <td>
                                        {{ $company->company_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.address') }}
                                    </th>
                                    <td>
                                        {{ $company->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.street') }}
                                    </th>
                                    <td>
                                        {{ $company->street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $company->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $company->state }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.zip_code') }}
                                    </th>
                                    <td>
                                        {{ $company->zip_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.country') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Company::COUNTRY_SELECT[$company->country] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.timezone') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Company::TIMEZONE_SELECT[$company->timezone] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.company.fields.active') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $company->active ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.companies.index') }}">
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