@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.kelurahan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.kelurahans.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.kelurahan.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kelurahan.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kecamatans_id">{{ trans('cruds.kelurahan.fields.kecamatans') }}</label>
                <select class="form-control select2 {{ $errors->has('kecamatans') ? 'is-invalid' : '' }}" name="kecamatans_id" id="kecamatans_id" required>
                    @foreach($kecamatans as $id => $entry)
                        <option value="{{ $id }}" {{ old('kecamatans_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kecamatans'))
                    <span class="text-danger">{{ $errors->first('kecamatans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kelurahan.fields.kecamatans_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="geojson">{{ trans('cruds.kelurahan.fields.geojson') }}</label>
                <textarea class="form-control {{ $errors->has('geojson') ? 'is-invalid' : '' }}" name="geojson" id="geojson">{{ old('geojson') }}</textarea>
                @if($errors->has('geojson'))
                    <span class="text-danger">{{ $errors->first('geojson') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kelurahan.fields.geojson_helper') }}</span>
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
