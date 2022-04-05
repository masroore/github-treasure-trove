@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.risk.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.risks.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.risk.fields.year') }}</label>
                <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" id="year" required>
                    <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Risk::YEAR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('year', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.risk.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kelurahan_id">{{ trans('cruds.risk.fields.kelurahan') }}</label>
                <select class="form-control select2 {{ $errors->has('kelurahan') ? 'is-invalid' : '' }}" name="kelurahan_id" id="kelurahan_id" required>
                    @foreach($kelurahans as $id => $entry)
                        <option value="{{ $id }}" {{ old('kelurahan_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kelurahan'))
                    <span class="text-danger">{{ $errors->first('kelurahan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.risk.fields.kelurahan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.risk.fields.level') }}</label>
                <select class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" name="level" id="level" required>
                    <option value disabled {{ old('level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Risk::LEVEL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('level', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('level'))
                    <span class="text-danger">{{ $errors->first('level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.risk.fields.level_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
