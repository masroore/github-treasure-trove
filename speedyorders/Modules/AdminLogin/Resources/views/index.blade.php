@extends('adminlogin::layouts.master')

@section('content')

    <div class="login-container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center m-b-md">
                    <h3>LOGIN</h3>
                </div>
                <div class="text-center m-b-md">
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <strong>{{Session::get('error_message')}}</strong>
                        </div>
                    @endif
                </div>

                <div class="hpanel">
                    <div class="panel-body">
                        <form action="{{route('admin.login.submit')}}" method="post" id="loginForm">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="example@gmail.com" class="form-control {{ $errors->first('username') ? 'error' : '' }}" title="Please enter you username" required="" value="{{ isset($admin_rem_username) && $admin_rem_username !="" ? $admin_rem_username :old('username') }}" name="username" id="username" >
                                @if($errors->first('username'))
                                    <label id="-error" class="error" for="">Please enter a valid email address.</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="{{ isset($admin_rem_password) && $admin_rem_password !="" ? $admin_rem_password : old('password') }}" name="password" id="password" class="form-control">
                                @if($errors->first('password'))
                                    <label id="-error" class="error" for="">Please enter a valid password.</label>
                                @endif
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" class="i-checks" name="remember_me" {{ (isset($admin_rem_password) && $admin_rem_password !="") && (isset($admin_rem_username) && $admin_rem_username !="") ?'checked' :''}}>
                                Remember login
                            </div>
                            <button class="btn btn-success btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
