@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.session.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.sessions.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('session') ? 'has-error' : '' }}">
                            <label class="required" for="session">{{ trans('cruds.session.fields.session') }}</label>
                            <input class="form-control" type="text" name="session" id="session" value="{{ old('session', '') }}" required>
                            @if($errors->has('session'))
                                <span class="help-block" role="alert">{{ $errors->first('session') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.session_helper') }}</span>
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