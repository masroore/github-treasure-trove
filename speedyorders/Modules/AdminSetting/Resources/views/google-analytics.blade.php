@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Google Analytics URL</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.googleanalytics') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group{{ $errors->has('google_analytics_url') ? ' has-error' :'' }}">
                            <label for="">Google Analytics URL</label>
                            <input type="text" name="google_analytics_url" id="" class="form-control" value="{{ old('google_analytics_url',Option::get('google_analytics_url')) }}">
                            @if($errors->has('google_analytics_url'))
                                <span class="help-block">{{ $errors->first('google_analytics_url') }}</span>
                            @endif
                        </div>

                        <div class="col-md-12 text-right">
                            @csrf
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
