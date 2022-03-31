@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.faculty.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.faculties.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="falculty_name">{{ trans('cruds.faculty.fields.falculty_name') }}</label>
                <input class="form-control {{ $errors->has('falculty_name') ? 'is-invalid' : '' }}" type="text" name="falculty_name" id="falculty_name" value="{{ old('falculty_name', '') }}" required>
                @if($errors->has('falculty_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('falculty_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.falculty_name_helper') }}</span>
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