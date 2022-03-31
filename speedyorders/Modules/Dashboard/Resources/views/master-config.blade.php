@extends('layouts.main')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                MASTER CONFIGURATIONS
            </h3>
        </div>

        <form action="" method="POST" class="panel-body form-horizontal form-padding">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @csrf

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">Password</label>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
                        <small class="help-block text-danger">{{$errors->first('password')}}</small>
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">License Secret Key</label>
                    <div class="col-md-6">
                        <input class="form-control" name="license_secret_key" value="{{ Option::get('license_secret_key') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="admin-first-name">Token TTL SDK(Minutes)</label>
                    <div class="col-md-6">
                        <input class="form-control" name="token_ttl_sdk" value="{{ Option::get('token_ttl_sdk') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-block btn-primary" name="update_master_config" value="SUBMIT">
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
