@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.studentStatusCheck.title') }}
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route("admin.check_status") }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-sm-6">
                <select class="form-control select2 {{ $errors->has('course_id') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                    @foreach($courses as $id => $entry)
                        <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.faculty_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <button class="btn btn-danger" type="submit">
                    Obtain Records For This Course
                </button>
            </div>
        </div>
        </form>
    </div>
</div>



@endsection