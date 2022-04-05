@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.nsup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.nsups.update", [$nsup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="categories_id">{{ trans('cruds.nsup.fields.categories') }}</label>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories_id" id="categories_id" required>
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('categories_id') ? old('categories_id') : $nsup->categories->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kecamatans_id">{{ trans('cruds.nsup.fields.kecamatans') }}</label>
                <select class="form-control select2 {{ $errors->has('kecamatans') ? 'is-invalid' : '' }}" name="kecamatans_id" id="kecamatans_id" required>
                    @foreach($kecamatans as $id => $entry)
                        <option value="{{ $id }}" {{ (old('kecamatans_id') ? old('kecamatans_id') : $nsup->kecamatans->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kecamatans'))
                    <span class="text-danger">{{ $errors->first('kecamatans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.kecamatans_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kelurahans_id">{{ trans('cruds.nsup.fields.kelurahans') }}</label>
                <select class="form-control select2 {{ $errors->has('kelurahans') ? 'is-invalid' : '' }}" name="kelurahans_id" id="kelurahans_id" required>
                    @foreach($kelurahans as $id => $entry)
                        <option value="{{ $id }}" {{ (old('kelurahans_id') ? old('kelurahans_id') : $nsup->kelurahans->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kelurahans'))
                    <span class="text-danger">{{ $errors->first('kelurahans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.kelurahans_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.nsup.fields.years') }}</label>
                <select class="form-control {{ $errors->has('years') ? 'is-invalid' : '' }}" name="years" id="years" required>
                    <option value disabled {{ old('years', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Nsup::YEARS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('years', $nsup->years) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('years'))
                    <span class="text-danger">{{ $errors->first('years') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.years_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lat">{{ trans('cruds.nsup.fields.lat') }}</label>
                <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="text" name="lat" id="lat" value="{{ old('lat', $nsup->lat) }}">
                @if($errors->has('lat'))
                    <span class="text-danger">{{ $errors->first('lat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lng">{{ trans('cruds.nsup.fields.lng') }}</label>
                <input class="form-control {{ $errors->has('lng') ? 'is-invalid' : '' }}" type="text" name="lng" id="lng" value="{{ old('lng', $nsup->lng) }}">
                @if($errors->has('lng'))
                    <span class="text-danger">{{ $errors->first('lng') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.nsup.fields.lng_helper') }}</span>
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
