@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.studentProfile.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-profiles.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="student_name">{{ trans('cruds.studentProfile.fields.student_name') }}</label>
                <input class="form-control {{ $errors->has('student_name') ? 'is-invalid' : '' }}" type="text" name="student_name" id="student_name" value="{{ old('student_name', '') }}" required>
                @if($errors->has('student_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.student_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="matric_number">{{ trans('cruds.studentProfile.fields.matric_number') }}</label>
                <input class="form-control {{ $errors->has('matric_number') ? 'is-invalid' : '' }}" type="text" name="matric_number" id="matric_number" value="{{ old('matric_number', '') }}" required>
                @if($errors->has('matric_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('matric_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.matric_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.studentProfile.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentProfile::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="faculty_id">{{ trans('cruds.studentProfile.fields.faculty') }}</label>
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
                <span class="help-block">{{ trans('cruds.studentProfile.fields.faculty_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="department_id">{{ trans('cruds.studentProfile.fields.department') }}</label>
                <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id" required>
                    @foreach($departments as $id => $entry)
                        <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.department_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.studentProfile.fields.level') }}</label>
                <select class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" name="level" id="level" required>
                    <option value disabled {{ old('level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentProfile::LEVEL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('level', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('level'))
                    <div class="invalid-feedback">
                        {{ $errors->first('level') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="passport">{{ trans('cruds.studentProfile.fields.passport') }}</label>
                <div class="needsclick dropzone {{ $errors->has('passport') ? 'is-invalid' : '' }}" id="passport-dropzone">
                </div>
                @if($errors->has('passport'))
                    <div class="invalid-feedback">
                        {{ $errors->first('passport') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentProfile.fields.passport_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.passportDropzone = {
    url: '{{ route('admin.student-profiles.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="passport"]').remove()
      $('form').append('<input type="hidden" name="passport" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="passport"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($studentProfile) && $studentProfile->passport)
      var file = {!! json_encode($studentProfile->passport) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="passport" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection