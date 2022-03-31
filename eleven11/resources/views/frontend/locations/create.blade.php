@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.location.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.locations.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="location_code">{{ trans('cruds.location.fields.location_code') }}</label>
                            <input class="form-control" type="text" name="location_code" id="location_code" value="{{ old('location_code', '') }}" required>
                            @if($errors->has('location_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('location_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.location_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="location_name">{{ trans('cruds.location.fields.location_name') }}</label>
                            <input class="form-control" type="text" name="location_name" id="location_name" value="{{ old('location_name', '') }}" required>
                            @if($errors->has('location_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('location_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.location_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="street_address">{{ trans('cruds.location.fields.street_address') }}</label>
                            <input class="form-control" type="text" name="street_address" id="street_address" value="{{ old('street_address', '') }}" required>
                            @if($errors->has('street_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street_address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.street_address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.location.fields.city') }}</label>
                            <select class="form-control" name="city" id="city" required>
                                <option value disabled {{ old('city', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Location::CITY_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('city', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.location.fields.state') }}</label>
                            <select class="form-control" name="state" id="state" required>
                                <option value disabled {{ old('state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Location::STATE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('state', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="country">{{ trans('cruds.location.fields.country') }}</label>
                            <input class="form-control" type="text" name="country" id="country" value="{{ old('country', '') }}" required>
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="zip_code">{{ trans('cruds.location.fields.zip_code') }}</label>
                            <input class="form-control" type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', '') }}" required>
                            @if($errors->has('zip_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('zip_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.zip_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="checkbox" name="active" id="active" value="1" required {{ old('active', 0) == 1 ? 'checked' : '' }}>
                                <label class="required" for="active">{{ trans('cruds.location.fields.active') }}</label>
                            </div>
                            @if($errors->has('active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('active') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.active_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="latitude">{{ trans('cruds.location.fields.latitude') }}</label>
                            <input class="form-control" type="text" name="latitude" id="latitude" value="{{ old('latitude', '') }}">
                            @if($errors->has('latitude'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('latitude') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.latitude_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="longitude">{{ trans('cruds.location.fields.longitude') }}</label>
                            <input class="form-control" type="text" name="longitude" id="longitude" value="{{ old('longitude', '') }}">
                            @if($errors->has('longitude'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('longitude') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.longitude_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="company_id">{{ trans('cruds.location.fields.company') }}</label>
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                @foreach($companies as $id => $company)
                                    <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>{{ $company }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('company'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.company_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="square_foot">{{ trans('cruds.location.fields.square_foot') }}</label>
                            <input class="form-control" type="number" name="square_foot" id="square_foot" value="{{ old('square_foot', '') }}" step="1">
                            @if($errors->has('square_foot'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('square_foot') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.square_foot_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="annual_budget">{{ trans('cruds.location.fields.annual_budget') }}</label>
                            <input class="form-control" type="number" name="annual_budget" id="annual_budget" value="{{ old('annual_budget', '') }}" step="0.01">
                            @if($errors->has('annual_budget'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('annual_budget') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.annual_budget_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="call_in_numbers">{{ trans('cruds.location.fields.call_in_numbers') }}</label>
                            <input class="form-control" type="text" name="call_in_numbers" id="call_in_numbers" value="{{ old('call_in_numbers', '') }}">
                            @if($errors->has('call_in_numbers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('call_in_numbers') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.location.fields.call_in_numbers_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection