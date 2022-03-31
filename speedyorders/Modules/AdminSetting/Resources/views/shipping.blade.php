@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Shipping Credentials</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.shipping') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <h3>For Live</h3>

                        <div class="form-group{{ $errors->has('ups_live_username') ? ' has-error' :'' }}">
                            <label for="">UPS UserName</label>
                            <input type="text" name="ups_live_username" id="" class="form-control" value="{{ old('ups_live_username',Option::get('ups_live_username')) }}">
                            @if($errors->has('ups_live_username'))
                                <span class="help-block">{{ $errors->first('ups_live_username') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('ups_live_password') ? ' has-error' :'' }}">
                            <label for="">UPS Password</label>
                            <input type="password" name="ups_live_password" id="" class="form-control" value="{{ old('ups_live_password',Option::get('ups_live_password')) }}">
                            @if($errors->has('ups_live_password'))
                                <span class="help-block">{{ $errors->first('ups_live_password') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('ups_live_api_key') ? ' has-error' :'' }}">
                            <label for="">Access Licence Number</label>
                            <input type="text" name="ups_live_api_key" id="" class="form-control" value="{{ old('ups_live_api_key',Option::get('ups_live_api_key')) }}">
                            @if($errors->has('ups_live_api_key'))
                                <span class="help-block">{{ $errors->first('ups_live_api_key') }}</span>
                            @endif
                        </div>

                        <h3>For Sandbox</h3>


                        <div class="form-group{{ $errors->has('ups_sandbox_username') ? ' has-error' :'' }}">
                            <label for="">UPS UserName</label>
                            <input type="text" name="ups_sandbox_username" id="" class="form-control" value="{{ old('ups_sandbox_username',Option::get('ups_sandbox_username')) }}">
                            @if($errors->has('ups_sandbox_username'))
                                <span class="help-block">{{ $errors->first('ups_sandbox_username') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('ups_sandbox_password') ? ' has-error' :'' }}">
                            <label for="">UPS Password</label>
                            <input type="password" name="ups_sandbox_password" id="" class="form-control" value="{{ old('ups_sandbox_password',Option::get('ups_sandbox_password')) }}">
                            @if($errors->has('ups_sandbox_password'))
                                <span class="help-block">{{ $errors->first('ups_sandbox_password') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('ups_sandbox_api_key') ? ' has-error' :'' }}">
                            <label for="">Access Licence Number</label>
                            <input type="text" name="ups_sandbox_api_key" id="" class="form-control" value="{{ old('ups_sandbox_api_key',Option::get('ups_sandbox_api_key')) }}">
                            @if($errors->has('ups_sandbox_api_key'))
                                <span class="help-block">{{ $errors->first('ups_sandbox_api_key') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">API mode</label>
                            <div class="checkbox">
                                <input id="status" class="i-checks" type="radio" name="ups_api_mode" value="LIVE" @if(old('ups_api_mode',Option::get('ups_api_mode'))=='LIVE') checked @endif>
                                <label for="status" style="color:#000000;">Live</label>
                                <input id="status-2" class="i-checks" type="radio" name="ups_api_mode" value="SANDBOX" @if(old('ups_api_mode',Option::get('ups_api_mode'))=='SANDBOX') checked @endif>
                                <label for="status-2" style="color:#000000;">Sandbox</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('box_length') ? ' has-error' :'' }}">
                            <label for="">Length</label>
                            <input type="text" name="box_length" id="" class="form-control" value="{{ old('box_length',Option::get('box_length')) }}">
                            @if($errors->has('box_length'))
                                <span class="help-block">{{ $errors->first('box_length') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('box_breadth') ? ' has-error' :'' }}">
                            <label for="">Breadth</label>
                            <input type="text" name="box_breadth" id="" class="form-control" value="{{ old('box_breadth',Option::get('box_breadth')) }}">
                            @if($errors->has('box_breadth'))
                                <span class="help-block">{{ $errors->first('box_breadth') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('box_height') ? ' has-error' :'' }}">
                            <label for="">Height</label>
                            <input type="text" name="box_height" id="" class="form-control" value="{{ old('box_height',Option::get('box_height')) }}">
                            @if($errors->has('box_height'))
                                <span class="help-block">{{ $errors->first('box_height') }}</span>
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
