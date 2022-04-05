@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.density.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.densities.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="kelurahans_id">{{ trans('cruds.density.fields.kelurahans') }}</label>
                <select class="form-control select2 {{ $errors->has('kelurahans') ? 'is-invalid' : '' }}" name="kelurahans_id" id="kelurahans_id" required>
                    @foreach($kelurahans as $id => $entry)
                        <option value="{{ $id }}" {{ old('kelurahans_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kelurahans'))
                    <span class="text-danger">{{ $errors->first('kelurahans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.density.fields.kelurahans_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="area">{{ trans('cruds.density.fields.area') }}</label>
                <input class="form-control {{ $errors->has('area') ? 'is-invalid' : '' }}" type="number" name="area" id="area" value="{{ old('area', '') }}" step="0.01" required>
                @if($errors->has('area'))
                    <span class="text-danger">{{ $errors->first('area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.density.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="population">{{ trans('cruds.density.fields.population') }}</label>
                <input class="form-control {{ $errors->has('population') ? 'is-invalid' : '' }}" type="number" name="population" id="population" value="{{ old('population', '') }}" step="1" required>
                @if($errors->has('population'))
                    <span class="text-danger">{{ $errors->first('population') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.density.fields.population_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="density">{{ trans('cruds.density.fields.density') }}</label>
                <input class="form-control {{ $errors->has('density') ? 'is-invalid' : '' }}" type="number" name="density" id="density" value="{{ old('density', '') }}" step="1" required>
                @if($errors->has('density'))
                    <span class="text-danger">{{ $errors->first('density') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.density.fields.density_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.density.fields.year') }}</label>
                <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" id="year" required>
                    <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Density::YEAR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('year', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.density.fields.year_helper') }}</span>
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
