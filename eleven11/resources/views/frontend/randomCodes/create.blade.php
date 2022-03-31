@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.randomCode.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.random-codes.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="code">{{ trans('cruds.randomCode.fields.code') }}</label>
                            <input class="form-control" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                            @if($errors->has('code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.randomCode.fields.code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="active">{{ trans('cruds.randomCode.fields.active') }}</label>
                            <input class="form-control" type="number" name="active" id="active" value="{{ old('active', '1') }}" step="1" required>
                            @if($errors->has('active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('active') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.randomCode.fields.active_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="location_code_id">{{ trans('cruds.randomCode.fields.location_code') }}</label>
                            <select class="form-control select2" name="location_code_id" id="location_code_id" required>
                                @foreach($location_codes as $id => $location_code)
                                    <option value="{{ $id }}" {{ old('location_code_id') == $id ? 'selected' : '' }}>{{ $location_code }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('location_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('location_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.randomCode.fields.location_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="company_id">{{ trans('cruds.randomCode.fields.company') }}</label>
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
                            <span class="help-block">{{ trans('cruds.randomCode.fields.company_helper') }}</span>
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