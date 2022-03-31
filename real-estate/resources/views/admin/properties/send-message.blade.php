@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.message.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("admin.messages.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="full_name">{{ trans('cruds.message.fields.full_name') }}</label>
                            <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name', '') }}" required>
                            @if($errors->has('full_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('full_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.full_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_number">{{ trans('cruds.message.fields.phone_number') }}</label>
                            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', '254') }}" required>
                            @if($errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.phone_number_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="message">{{ trans('cruds.message.fields.message') }}</label>
                            <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" required>{{ old('message') }}</textarea>
                            @if($errors->has('message'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('message') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.message.fields.message_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-lg" type="submit">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
