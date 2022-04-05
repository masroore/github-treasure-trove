@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sanitation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sanitations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="kecamatan_id">{{ trans('cruds.sanitation.fields.kecamatan') }}</label>
                <select class="form-control select2 {{ $errors->has('kecamatan') ? 'is-invalid' : '' }}" name="kecamatan_id" id="kecamatan_id" required>
                    @foreach($kecamatans as $id => $entry)
                        <option value="{{ $id }}" {{ old('kecamatan_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kecamatan'))
                    <span class="text-danger">{{ $errors->first('kecamatan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sanitation.fields.kecamatan_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sanitation.fields.year') }}</label>
                <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" id="year">
                    <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sanitation::YEAR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('year', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sanitation.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="secure">{{ trans('cruds.sanitation.fields.secure') }}</label>
                <input class="form-control {{ $errors->has('secure') ? 'is-invalid' : '' }}" type="number" name="secure" id="secure" value="{{ old('secure', '') }}" step="1" required>
                @if($errors->has('secure'))
                    <span class="text-danger">{{ $errors->first('secure') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sanitation.fields.secure_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="basic">{{ trans('cruds.sanitation.fields.basic') }}</label>
                <input class="form-control {{ $errors->has('basic') ? 'is-invalid' : '' }}" type="number" name="basic" id="basic" value="{{ old('basic', '') }}" step="1" required>
                @if($errors->has('basic'))
                    <span class="text-danger">{{ $errors->first('basic') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sanitation.fields.basic_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="poor">{{ trans('cruds.sanitation.fields.poor') }}</label>
                <input class="form-control {{ $errors->has('poor') ? 'is-invalid' : '' }}" type="number" name="poor" id="poor" value="{{ old('poor', '') }}" step="1" required>
                @if($errors->has('poor'))
                    <span class="text-danger">{{ $errors->first('poor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sanitation.fields.poor_helper') }}</span>
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
