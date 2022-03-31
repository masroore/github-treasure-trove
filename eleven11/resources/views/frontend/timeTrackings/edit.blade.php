@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.timeTracking.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.time-trackings.update", [$timeTracking->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.timeTracking.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $timeTracking->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="checkin_time">{{ trans('cruds.timeTracking.fields.checkin_time') }}</label>
                            <input class="form-control timepicker" type="text" name="checkin_time" id="checkin_time" value="{{ old('checkin_time', $timeTracking->checkin_time) }}" required>
                            @if($errors->has('checkin_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('checkin_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.checkin_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="checkout_time">{{ trans('cruds.timeTracking.fields.checkout_time') }}</label>
                            <input class="form-control timepicker" type="text" name="checkout_time" id="checkout_time" value="{{ old('checkout_time', $timeTracking->checkout_time) }}">
                            @if($errors->has('checkout_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('checkout_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.checkout_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="total_hours">{{ trans('cruds.timeTracking.fields.total_hours') }}</label>
                            <input class="form-control" type="text" name="total_hours" id="total_hours" value="{{ old('total_hours', $timeTracking->total_hours) }}">
                            @if($errors->has('total_hours'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_hours') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.total_hours_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="status">{{ trans('cruds.timeTracking.fields.status') }}</label>
                            <input class="form-control" type="number" name="status" id="status" value="{{ old('status', $timeTracking->status) }}" step="1" required>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="random_code_id">{{ trans('cruds.timeTracking.fields.random_code') }}</label>
                            <select class="form-control select2" name="random_code_id" id="random_code_id" required>
                                @foreach($random_codes as $id => $random_code)
                                    <option value="{{ $id }}" {{ (old('random_code_id') ? old('random_code_id') : $timeTracking->random_code->id ?? '') == $id ? 'selected' : '' }}>{{ $random_code }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('random_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('random_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.random_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="shift_id">{{ trans('cruds.timeTracking.fields.shift') }}</label>
                            <select class="form-control select2" name="shift_id" id="shift_id" required>
                                @foreach($shifts as $id => $shift)
                                    <option value="{{ $id }}" {{ (old('shift_id') ? old('shift_id') : $timeTracking->shift->id ?? '') == $id ? 'selected' : '' }}>{{ $shift }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('shift'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('shift') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.shift_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="location_id">{{ trans('cruds.timeTracking.fields.location') }}</label>
                            <select class="form-control select2" name="location_id" id="location_id">
                                @foreach($locations as $id => $location)
                                    <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $timeTracking->location->id ?? '') == $id ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('location'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('location') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.location_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="company_id">{{ trans('cruds.timeTracking.fields.company') }}</label>
                            <select class="form-control select2" name="company_id" id="company_id">
                                @foreach($companies as $id => $company)
                                    <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $timeTracking->company->id ?? '') == $id ? 'selected' : '' }}>{{ $company }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('company'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.timeTracking.fields.company_helper') }}</span>
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