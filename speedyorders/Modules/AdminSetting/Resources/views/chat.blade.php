@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Chat Scripts</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.chat') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group{{ $errors->has('chat_script') ? ' has-error' :'' }}">
                            <label for="">Chat Script Tag</label>
                            <textarea name="chat_script" id="" cols="30" class="form-control" rows="5">{{ old('chat_script',Option::get('chat_script')) }}</textarea>
                            @if($errors->has('chat_script'))
                                <span class="help-block">{{ $errors->first('chat_script') }}</span>
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
