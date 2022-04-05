@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.secured.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.secureds.update", [$secured->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="kecamatan_id">{{ trans('cruds.secured.fields.kecamatan') }}</label>
                <select class="form-control select2 {{ $errors->has('kecamatan') ? 'is-invalid' : '' }}" name="kecamatan_id" id="kecamatan_id" required>
                    @foreach($kecamatans as $id => $entry)
                        <option value="{{ $id }}" {{ (old('kecamatan_id') ? old('kecamatan_id') : $secured->kecamatan->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('kecamatan'))
                    <span class="text-danger">{{ $errors->first('kecamatan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.kecamatan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="access_id">{{ trans('cruds.secured.fields.access') }}</label>
                <select class="form-control select2 {{ $errors->has('access') ? 'is-invalid' : '' }}" name="access_id" id="access_id" required>
                    @foreach($accesses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('access_id') ? old('access_id') : $secured->access->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('access'))
                    <span class="text-danger">{{ $errors->first('access') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.access_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="communal">{{ trans('cruds.secured.fields.communal') }}</label>
                <input class="form-control {{ $errors->has('communal') ? 'is-invalid' : '' }}" type="number" name="communal" id="communal" value="{{ old('communal', $secured->communal) }}" step="1" required>
                @if($errors->has('communal'))
                    <span class="text-danger">{{ $errors->first('communal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.communal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="individual">{{ trans('cruds.secured.fields.individual') }}</label>
                <input class="form-control {{ $errors->has('individual') ? 'is-invalid' : '' }}" type="number" name="individual" id="individual" value="{{ old('individual', $secured->individual) }}" step="1" required>
                @if($errors->has('individual'))
                    <span class="text-danger">{{ $errors->first('individual') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.individual_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mck_user">{{ trans('cruds.secured.fields.mck_user') }}</label>
                <input class="form-control {{ $errors->has('mck_user') ? 'is-invalid' : '' }}" type="number" name="mck_user" id="mck_user" value="{{ old('mck_user', $secured->mck_user) }}" step="1" required>
                @if($errors->has('mck_user'))
                    <span class="text-danger">{{ $errors->first('mck_user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.mck_user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="qty_sr_pdpal">{{ trans('cruds.secured.fields.qty_sr_pdpal') }}</label>
                <input class="form-control {{ $errors->has('qty_sr_pdpal') ? 'is-invalid' : '' }}" type="number" name="qty_sr_pdpal" id="qty_sr_pdpal" value="{{ old('qty_sr_pdpal', $secured->qty_sr_pdpal) }}" step="1" required>
                @if($errors->has('qty_sr_pdpal'))
                    <span class="text-danger">{{ $errors->first('qty_sr_pdpal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.qty_sr_pdpal_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.secured.fields.year') }}</label>
                <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" id="year">
                    <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Secured::YEAR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('year', $secured->year) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.secured.fields.year_helper') }}</span>
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
