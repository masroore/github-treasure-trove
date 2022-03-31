@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.shift.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.shifts.update", [$shift->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="shift_name">{{ trans('cruds.shift.fields.shift_name') }}</label>
                            <input class="form-control" type="text" name="shift_name" id="shift_name" value="{{ old('shift_name', $shift->shift_name) }}" required>
                            @if($errors->has('shift_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('shift_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.shift_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="start_date">{{ trans('cruds.shift.fields.start_date') }}</label>
                            <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date', $shift->start_date) }}" required>
                            @if($errors->has('start_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.start_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="end_date">{{ trans('cruds.shift.fields.end_date') }}</label>
                            <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date', $shift->end_date) }}">
                            @if($errors->has('end_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.end_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="start_time">{{ trans('cruds.shift.fields.start_time') }}</label>
                            <input class="form-control timepicker" type="text" name="start_time" id="start_time" value="{{ old('start_time', $shift->start_time) }}">
                            @if($errors->has('start_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.start_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="end_time">{{ trans('cruds.shift.fields.end_time') }}</label>
                            <input class="form-control timepicker" type="text" name="end_time" id="end_time" value="{{ old('end_time', $shift->end_time) }}">
                            @if($errors->has('end_time'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_time') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.end_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="checkbox" name="days" id="days" value="1" {{ $shift->days || old('days', 0) === 1 ? 'checked' : '' }} required>
                                <label class="required" for="days">{{ trans('cruds.shift.fields.days') }}</label>
                            </div>
                            @if($errors->has('days'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('days') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.days_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.shift.fields.frequency') }}</label>
                            <select class="form-control" name="frequency" id="frequency">
                                <option value disabled {{ old('frequency', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Shift::FREQUENCY_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('frequency', $shift->frequency) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('frequency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('frequency') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.frequency_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="company_id">{{ trans('cruds.shift.fields.company') }}</label>
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                @foreach($companies as $id => $company)
                                    <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $shift->company->id ?? '') == $id ? 'selected' : '' }}>{{ $company }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('company'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.company_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="checkbox" name="active" id="active" value="1" {{ $shift->active || old('active', 0) === 1 ? 'checked' : '' }} required>
                                <label class="required" for="active">{{ trans('cruds.shift.fields.active') }}</label>
                            </div>
                            @if($errors->has('active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('active') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.active_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="users">{{ trans('cruds.shift.fields.user') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="users[]" id="users" multiple required>
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}" {{ (in_array($id, old('users', [])) || $shift->users->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('users'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('users') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="locations">{{ trans('cruds.shift.fields.location') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="locations[]" id="locations" multiple required>
                                @foreach($locations as $id => $location)
                                    <option value="{{ $id }}" {{ (in_array($id, old('locations', [])) || $shift->locations->contains($id)) ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('locations'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('locations') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shift.fields.location_helper') }}</span>
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