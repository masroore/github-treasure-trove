@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.semester.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.semesters.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('semester') ? 'has-error' : '' }}">
                            <label>{{ trans('cruds.semester.fields.semester') }}</label>
                            <select class="form-control" name="semester" id="semester">
                                <option value disabled {{ old('semester', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Semester::SEMESTER_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('semester', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('semester'))
                                <span class="help-block" role="alert">{{ $errors->first('semester') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.semester.fields.semester_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection