@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Details For {{ $course->course_code }}
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route("admin.confirm") }}" enctype="multipart/form-data">
            <div class="form-group">
                <label class="required" for="course">Course Title</label>
                <input class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" type="text" name="course" id="course" value="{{ $course->course_title }}" readonly>
                <input type="text" value="{{ $course->id }}" name="course_id" hidden>
                @if($errors->has('course'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="faculty">{{ trans('cruds.studentProfile.fields.faculty') }}</label>
                <input class="form-control {{ $errors->has('faculty') ? 'is-invalid' : '' }}" type="text" name="faculty" id="faculty" value="{{ $faculty->falculty_name }}" readonly>
                @if($errors->has('faculty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faculty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.faculty_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="department">{{ trans('cruds.studentProfile.fields.department') }}</label>
                <input class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" type="text" name="department" id="department" value="{{ $dept->department_name }}" readonly>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.department_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lecturer">Course Lecturer</label>
                <input class="form-control {{ $errors->has('lecturer') ? 'is-invalid' : '' }}" type="text" name="lecturer" id="lecturer" value="{{ $lecturer->name }}" readonly>
                @if($errors->has('lecturer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lecturer') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Confirm Exam Candidates
                </button>
            </div>
        </form>
    </div>
</div>



@endsection