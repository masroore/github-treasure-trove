@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.update", [$course->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="course_title">{{ trans('cruds.course.fields.course_title') }}</label>
                <input class="form-control {{ $errors->has('course_title') ? 'is-invalid' : '' }}" type="text" name="course_title" id="course_title" value="{{ old('course_title', $course->course_title) }}" required>
                @if($errors->has('course_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.course_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="course_code">{{ trans('cruds.course.fields.course_code') }}</label>
                <input class="form-control {{ $errors->has('course_code') ? 'is-invalid' : '' }}" type="text" name="course_code" id="course_code" value="{{ old('course_code', $course->course_code) }}" required>
                @if($errors->has('course_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.course_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="course_lecturer_id">{{ trans('cruds.course.fields.course_lecturer') }}</label>
                <select class="form-control select2 {{ $errors->has('course_lecturer') ? 'is-invalid' : '' }}" name="course_lecturer_id" id="course_lecturer_id" required>
                    @foreach($course_lecturers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('course_lecturer_id') ? old('course_lecturer_id') : $course->course_lecturer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_lecturer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_lecturer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.course_lecturer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="department_id">{{ trans('cruds.course.fields.department') }}</label>
                <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id" required>
                    @foreach($departments as $id => $entry)
                        <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $course->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.department_helper') }}</span>
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