@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.department.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.departments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="department_name">{{ trans('cruds.department.fields.department_name') }}</label>
                <input class="form-control {{ $errors->has('department_name') ? 'is-invalid' : '' }}" type="text" name="department_name" id="department_name" value="{{ old('department_name', '') }}" required>
                @if($errors->has('department_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.department_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="hod_id">{{ trans('cruds.department.fields.hod') }}</label>
                <select class="form-control select2 {{ $errors->has('hod') ? 'is-invalid' : '' }}" name="hod_id" id="hod_id" required>
                    @foreach($hods as $id => $entry)
                        <option value="{{ $id }}" {{ old('hod_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hod'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hod') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.hod_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="faculty_id">{{ trans('cruds.department.fields.faculty') }}</label>
                <select class="form-control select2 {{ $errors->has('faculty') ? 'is-invalid' : '' }}" name="faculty_id" id="faculty_id" required>
                    @foreach($faculties as $id => $entry)
                        <option value="{{ $id }}" {{ old('faculty_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('faculty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faculty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.faculty_helper') }}</span>
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